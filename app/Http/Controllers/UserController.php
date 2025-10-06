<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class UserController extends Controller
{
    /**
     * Mostrar listado de usuarios
     */
    public function index()
    {
        $users = User::all();
        return view('pages.usuarios.index', compact('users'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('pages.usuarios.create');
    }

    /**
     * Guardar usuario en BD
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:50',
            'apellido'  => 'required|string|max:50',
            'email'     => 'required|email|unique:users,email',
            'estado'    => 'required|in:1,0',
            'foto_url'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            DB::transaction(function () use ($request) {
                if ($request->hasFile('foto_url')) {
                    $file = $request->file('foto_url');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('usuarios', $filename, 'public');
                    
                    $fotoPath = $request->file('foto_url')->store('usuarios', 'public');
                } else {
                    $fotoPath = "https://ui-avatars.com/api/?name=" . urlencode("{$request->nombre} {$request->apellido}") . "&background=random&color=fff";
                }

                $user = User::create([
                    'nombre'    => $request->nombre,
                    'apellido'  => $request->apellido,
                    'username'  => Str::slug($request->nombre . '.' . $request->apellido) . rand(100, 999),
                    'email'     => $request->email,
                    'password'  => $request->nombre . $request->apellido . rand(10, 99), // Contraseña temporal
                    'estado'    => $request->estado,
                    'foto_url'  => $fotoPath,
                    'uid'       => Str::uuid(),
                ]);

                RoleUser::create([
                    'user_id' => $user->id,
                    'role_id' => 4,
                    'estado'  => 1,
                    'uid'     => Str::uuid(),
                ]);
            });

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario creado correctamente.');
        } catch (\Throwable $e) {
            Log::error('[store Usuario] Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'No se pudo crear el usuario, inténtalo de nuevo.']);
        }
    }


    /**
     * Mostrar un usuario específico
     */
    public function show(Request $request)
    {
        $query = User::select(
            'users.*',
            'role_users.role_id',
            'roles.nombre as rol_texto'
        )
            ->leftJoin('role_users', 'users.id', '=', 'role_users.user_id')
            ->leftJoin('roles', 'role_users.role_id', '=', 'roles.id')
            ->where('users.estado', 1);

        if ($request->has('search') && !empty($request->search)) {
            $query->where('users.username', 'LIKE', '%' . $request->search . '%');
        }

        $usuarios = $query->paginate(10);

        return response()->json($usuarios);
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($uid)
    {
        $user = User::where('uid', $uid)->firstOrFail();

        $userRole = DB::table('role_users')
            ->where('user_id', $user->id)
            ->value('role_id');

        return view('pages.usuarios.edit', compact('user', 'userRole'));
    }

    public function update(Request $request, $uid)
    {
        $user = User::where('uid', $uid)->firstOrFail();

        $request->validate([
            'nombre'    => 'required|string|max:50',
            'apellido'    => 'required|string|max:50',
            'username'    => 'required|string|max:50',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'estado'    => 'required|in:1,0',
            'foto_url'  => 'nullable|file|image|max:2048',
            'id_rol'    => 'required|integer|exists:roles,id',

        ]);

        $data = $request->only(['nombre', 'apellido', 'username', 'email', 'estado']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Procesar foto
        if ($request->hasFile('foto_url')) {

            $data['foto_url'] = $request->file('foto_url')->store('usuarios', 'public');
        } elseif (!$user->foto_url) {
            $data['foto_url'] = "https://ui-avatars.com/api/?name=" . urlencode("{$request->username} {$request->apellido}") . "&background=random&color=fff";
        }

        $user->update($data);

        // Actualizar rol en tabla role_users
        DB::table('role_users')
            ->updateOrInsert(
                ['user_id' => $user->id],
                ['role_id' => $request->id_rol, 'estado' => $request->estado, 'uid' => $user->uid]
            );

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($uid)
    {
        $usuario = User::where('uid', $uid)->first();

        if (!$usuario) {
            return response()->json(['success' => false, 'error' => 'Usuario no encontrada.']);
        }

        $usuario->estado = 0;
        $usuario->save();

        return response()->json(['success' => true]);
    }

    public function showRoles()
    {
        $roles = Roles::where('estado', 1)->get();
        return response()->json($roles);
    }


    public function deleteFotoPerfil($uid)
    {
        $user = User::where('uid', $uid)->firstOrFail();

        if ($user->foto_url && Storage::exists($user->foto_url)) {
            Storage::delete($user->foto_url);
        }

        $user->foto_url = null;
        $user->save();

        return response()->json(['success' => true]);
    }

    public function profile($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        return view('pages.profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(auth()->id());

        $request->validate([
            'nombre'    => 'required|string|max:50',
            'username'    => 'required|string|max:50',
            'apellido'  => 'nullable|string|max:50',
            'email'     => 'required|email|max:255|unique:users,email,' . $user->id,
            'foto_url'  => 'nullable|file|image|max:2048',
        ]);

        $data = $request->only(['nombre','username', 'email']);

        if ($request->hasFile('foto_url')) {
            $data['foto_url'] = $request->file('foto_url')->store('usuarios', 'public');
        } elseif (!$user->foto_url) {
            $data['foto_url'] = "https://ui-avatars.com/api/?name=" . urlencode("{$request->nombre} {$request->apellido}") . "&background=random&color=fff";
        }

        $user->update($data);


        $request->validate([
            'nombre'    => 'required|string|max:50',
            'username'    => 'required|string|max:50',
            'apellido'  => 'required|string|max:50',
            'email'     => 'required|email|max:255|unique:users,email,' . $user->id,
            'foto_url'  => 'nullable|file|image|max:2048',
        ]);

        $data = $request->only(['nombre', 'username', 'apellido', 'email']);

        if ($request->hasFile('foto_url')) {
            $data['foto_url'] = $request->file('foto_url')->store('usuarios', 'public');
        } elseif (!$user->foto_url) {
            $data['foto_url'] = "https://ui-avatars.com/api/?name=" . urlencode("{$request->nombre} {$request->apellido}") . "&background=random&color=fff";
        }
        $user->update($data);


        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'foto_url' => $user->foto_url
                    ? asset('storage/' . $user->foto_url)
                    : "https://ui-avatars.com/api/?name=" . urlencode("{$user->username} {$user->apellido}") . "&background=6e40c9&color=fff"
            ]);
        }

        return redirect()->route('user.profile', $user->username)
            ->with('success', 'Perfil actualizado correctamente.');
    }

    public function marcarTour(Request $request)
    {
        try {
            $userId = auth()->id();

            DB::table('users')
                ->where('id', $userId)
                ->update(['tour_completed' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Tour marcado como completado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado del tour: ' . $e->getMessage()
            ], 500);
        }
    }

    public function configuracion()
    {
        return view('pages.profile.settings');
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'apellido.required' => 'El apellido es obligatorio',
            'username.required' => 'El nombre de usuario es obligatorio',
            'username.unique' => 'Este nombre de usuario ya está en uso',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El correo electrónico no es válido',
            'email.unique' => 'Este correo electrónico ya está en uso',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            // Actualizar usando DB directamente sin modelo
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'nombre' => $request->nombre,
                    'apellido' => $request->apellido,
                    'username' => $request->username,
                    'email' => $request->email,
                    'updated_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Perfil actualizado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el perfil: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar foto de perfil
     */
    public function updatePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'foto.required' => 'Debes seleccionar una imagen',
            'foto.image' => 'El archivo debe ser una imagen',
            'foto.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg o gif',
            'foto.max' => 'La imagen no debe superar los 2MB',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $user = Auth::user();

            // Eliminar foto anterior si existe y no es externa
            if ($user->avatar && !str_starts_with($user->avatar, 'http')) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Guardar nueva foto en storage/app/public/usuarios
            $path = $request->file('foto')->store('usuarios', 'public');

            // Actualizar usuario usando DB directamente
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'avatar' => $path,
                    'foto_url' => null,
                    'updated_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Foto actualizada correctamente',
                'path' => $path
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la foto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar foto de perfil
     */
    public function deletePhoto()
    {
        try {
            $user = Auth::user();

            // Eliminar foto del storage si existe y no es externa
            if ($user->avatar && !str_starts_with($user->avatar, 'http')) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Actualizar usuario usando DB directamente
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'avatar' => null,
                    'foto_url' => null,
                    'updated_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Foto eliminada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la foto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cambiar contraseña
     */
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        // Si la cuenta está vinculada con Google, no permitir cambio de contraseña
        if ($user->google_id) {
            return response()->json([
                'success' => false,
                'message' => 'Las cuentas vinculadas con Google no pueden cambiar la contraseña'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
            ],
        ], [
            'current_password.required' => 'Debes ingresar tu contraseña actual',
            'new_password.required' => 'Debes ingresar una nueva contraseña',
            'new_password.confirmed' => 'Las contraseñas no coinciden',
            'new_password.min' => 'La contraseña debe tener al menos 8 caracteres',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'La contraseña actual es incorrecta'
            ], 422);
        }

        // Validar que la nueva contraseña cumpla los requisitos
        if (!preg_match('/[A-Z]/', $request->new_password)) {
            return response()->json([
                'success' => false,
                'message' => 'La contraseña debe contener al menos una mayúscula'
            ], 422);
        }

        if (!preg_match('/[a-z]/', $request->new_password)) {
            return response()->json([
                'success' => false,
                'message' => 'La contraseña debe contener al menos una minúscula'
            ], 422);
        }

        if (!preg_match('/[0-9]/', $request->new_password)) {
            return response()->json([
                'success' => false,
                'message' => 'La contraseña debe contener al menos un número'
            ], 422);
        }

        try {
            // Actualizar contraseña usando DB directamente
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'password' => Hash::make($request->new_password),
                    'updated_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Contraseña cambiada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar la contraseña: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Desactivar cuenta
     */
    public function deactivateAccount()
    {
        try {
            $user = Auth::user();

            // Desactivar cuenta usando DB directamente
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'estado' => 0,
                    'updated_at' => now()
                ]);

            // Cerrar sesión
            Auth::logout();

            return response()->json([
                'success' => true,
                'message' => 'Cuenta desactivada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al desactivar la cuenta: ' . $e->getMessage()
            ], 500);
        }
    }

}
