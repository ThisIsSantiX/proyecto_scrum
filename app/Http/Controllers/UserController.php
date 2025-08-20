<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        'estado'    => 'required|in:activo,inactivo',
        'id_rol'    => 'required|integer',
        'foto_url'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Subir foto si existe
    $fotoPath = null;
    if ($request->hasFile('foto_url')) {
        $fotoPath = $request->file('foto_url')->store('usuarios', 'public');
    }

    User::create([
        'nombre'    => $request->nombre,
        'apellido'  => $request->apellido,
        'email'     => $request->email,
        'password'  => Hash::make($request->password),
        'estado'    => $request->estado === 'activo' ? 1 : 0, 
        'id_rol'    => $request->id_rol,
        'foto_url'  => $fotoPath,
        'uid'       => uniqid("usr_"),
    ]);
    
    return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
}


    /**
     * Mostrar un usuario específico
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('pages.usuarios.detalle', compact('user'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.usuarios.edit', compact('user'));
    }

    /**
     * Actualizar usuario en BD
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nombre'    => 'required|string|max:50',
            'apellido'  => 'required|string|max:50',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'password'  => 'nullable|min:6|confirmed',
            'estado'    => 'required|in:activo,inactivo',
           'id_rol' => 'required|string|max:50',
            'foto_url'  => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }
        
        // Convertir estado antes de actualizar
        $data['estado'] = $request->estado === 'activo' ? 1 : 0;
        
        $user->update($data);
        

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->estado = 'inactivo';
        $user->save();
    
        return response()->json(['success' => true]);
    }
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}    