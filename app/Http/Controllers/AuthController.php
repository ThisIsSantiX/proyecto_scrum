<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    // Esta función muestra la vista de inicio de sesión
    public function index()
    {
        return view('pages.auth.login');
    }
    // Esta función muestra la vista de registro

    public function register()
    {
        return view('pages.auth.register');
    }
    // Procesar registro
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'estado' => 'activo',
        ]);

        return redirect()->route('login')->with('success', 'Cuenta creada correctamente');
    }

    public function showRecoveryForm()
    {
        return view('pages.auth.recoverypw');
    }

    public function confirmMail()
    {
        return view('pages.auth.confirm-mail');
    }

    // Funcion de inicio de sesión
    public function authLogin(Request $request)
    {
        // Validación de datos de entrada
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'El correo es requerido',
            'email.email' => 'El correo no es válido',
            'password.required' => 'La contraseña es requerida'
        ]);

        $credentials = $request->only('email', 'password');

        if (auth()->attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            session(['active_role_id' => 4]);
            session(['active_role_name' => 'Usuario']);

            return response()->json([
                'message' => 'Iniciando Sesión',
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'message' => 'Correo o contraseña incorrecto',
                'icon' => 'error'
            ]);
        }
    }

    // Funcion de cierre de sesión
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'Sesión cerrada correctamente');
    }

}
