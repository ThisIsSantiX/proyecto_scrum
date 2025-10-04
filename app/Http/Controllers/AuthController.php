<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password as PasswordFacade;  
use Illuminate\Validation\Rules\Password;

use Illuminate\Foundation\Auth\ThrottlesLogins;


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

    // Esta función muestra el formulario de recuperación de contraseña
    public function showRecoveryForm()
    {
        return view('pages.auth.recoverypw');
    }

    // Esta función muestra la vista de confirmación de correo electrónico
    public function showMailSent()
    {
        $email = session('email'); 
        return view('pages.auth.mail-sent', ['email' => $email]);
    }

    use ThrottlesLogins;

    public function username()
    {
        return 'email';
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

        if ($this->hasTooManyLoginAttempts($request)) {
            $seconds = $this->limiter()->availableIn(
                $this->throttleKey($request)
            );

            return response()->json([
                'message' => 'Demasiados intentos fallidos. Intenta de nuevo en ' . $seconds . ' segundos.',
                'retry_after' => $seconds
            ], 429);
        }


        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request); 

            session(['active_role_id' => 4]);
            session(['active_role_name' => 'Usuario']);

            return response()->json([
                'message' => 'Iniciando Sesión',
                'status' => 'success'
            ]);
        } else {
            $this->incrementLoginAttempts($request);

            return response()->json([
                'message' => 'Correo o contraseña incorrecto',
                'status' => 'error'
            ]);
        }
    }

    // Número máximo de intentos
    protected function maxAttempts()
    {
        return 3; 
    }

    // Tiempo de bloqueo
    protected function decayMinutes()
    {
        return 1; 
    }


    // Función de registro
    public function authRegister(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters() 
                    ->mixedCase()
                    ->numbers()
            ],
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
        ], [
            'email.required'     => 'El correo es requerido',
            'email.email'        => 'El correo no es válido',
            'email.unique'       => 'El correo ya está registrado',
            'password.required'  => 'La contraseña es requerida',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'nombre.required'    => 'El nombre es requerido',
            'apellido.required'  => 'El apellido es requerido',
        ]);

        try {
            $user = DB::transaction(function () use ($request) {
                $user = User::create([
                    'nombre'   => $request->nombre,
                    'apellido' => $request->apellido,
                    'username' => Str::slug($request->nombre . $request->apellido) . rand(100, 999),
                    'email'    => $request->email,
                    'password' => Hash::make($request->password),
                    'estado'   => 1,
                    'foto_url' => "https://ui-avatars.com/api/?name=" . urlencode("{$request->nombre} {$request->apellido}") . "&background=random&color=fff",
                    'uid'      => Str::uuid(),
                ]);

                RoleUser::create([
                    'user_id' => $user->id,
                    'role_id' => 4,
                    'estado'  => 1,
                    'uid'     => Str::uuid(),
                ]);

                return $user;
            });

            return response()->json([
                'message' => 'Registro exitoso, ahora puedes iniciar sesión.',
                'status'  => 'success',
                'user'    => $user
            ], 201);
        } catch (\Throwable $e) {
            Log::error('[authRegister] Error al registrar usuario: ' . $e->getMessage());

            return response()->json([
                'message' => 'No se pudo completar el registro, inténtalo de nuevo.',
                'status'  => 'error'
            ], 500);
        }
    }


    public function sendRecoveryEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = PasswordFacade::sendResetLink($request->only('email'));

        if ($status === PasswordFacade::RESET_LINK_SENT) {
            return redirect()->route('mail.sent')->with('email', $request->email);
        } else {
            return back()->withErrors(['email' => __($status)]);
        }
    }


    // Funcion de cierre de sesión
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/auth/login')->with('message', 'Sesión cerrada correctamente');
    }

    
}
