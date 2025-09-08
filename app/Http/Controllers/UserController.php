<?php

namespace App\Http\Controllers;
use App\Models\roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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
            'password'  => 'required|min:6|confirmed',
            'estado'    => 'required|in:1,0',
            'foto_url'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
             DB::transaction(function () use ($request) {
                 if ($request->hasFile('foto_url')) {
                    $file = $request->file('foto_url');
                    $filename = time().'_'.$file->getClientOriginalName();
                    $file->storeAs('usuarios', $filename, 'public');

                    $fotoPath = $filename;
                    $fotoPath = $request->file('foto_url')->store('usuarios', 'public');
                } else {
                   $fotoPath = "https://ui-avatars.com/api/?name=" . urlencode("{$request->nombre} {$request->apellido}") . "&background=random&color=fff";
                }


                User::create([
                    'nombre'    => $request->nombre,
                    'apellido'  => $request->apellido,
                    'email'     => $request->email,
                    'password'  => Hash::make($request->password),
                    'estado'    => $request->estado,
                    'foto_url'  => $fotoPath,
                    'uid'       => Str::uuid(),
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
            $query->where('users.nombre', 'LIKE', '%' . $request->search . '%');
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
            'apellido'  => 'required|string|max:50',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'password'  => 'nullable|min:6|confirmed',
            'estado'    => 'required|in:1,0',
            'foto_url'  => 'nullable|file|image|max:2048',
            'id_rol'    => 'required|integer|exists:roles,id',

        ]);

        $data = $request->only(['nombre', 'apellido', 'email', 'estado']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Procesar foto
        if ($request->hasFile('foto_url')) {

            $data['foto_url'] = $request->file('foto_url')->store('usuarios', 'public');
         } elseif (!$user->foto_url) {
            $data['foto_url'] = "https://ui-avatars.com/api/?name=" . urlencode("{$request->nombre} {$request->apellido}") . "&background=random&color=fff";
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
        $usuario = user::where('uid', $uid)->first();

        if (!$usuario) {
            return response()->json(['success' => false, 'error' => 'Usuario no encontrada.']);
        }

        $usuario->estado = 0;
        $usuario->save();

        return response()->json(['success' => true]);
    }

    public function showRoles()
    {
        $roles = roles::where('estado', 1)->get(); 
        return response()->json($roles);
    }


    public function deleteFoto($uid)
    {
        $user = User::where('uid', $uid)->firstOrFail();

        if ($user->foto_url) {
            Storage::delete($user->foto_url); // eliminar archivo
            $user->foto_url = null;
            $user->save();
        }

        return response()->json(['success' => true]);
    }
                

}    