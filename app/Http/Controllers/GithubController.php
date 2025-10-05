<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\RoleUser;


class GithubController extends Controller
{
   // Redirigir a GitHub
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    // Callback de GitHub
    public function handleProviderCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        // Tomar nickname como base
        $baseUsername = $githubUser->getNickname() ?? 'user' . $githubUser->getId();

        // Buscar si el usuario ya existe por email
        $user = User::where('email', $githubUser->getEmail())->first();

        if ($user) {
            // Usuario existe: actualizar datos de GitHub (sin cambiar username)
            $user->update([
                'foto_url' => $githubUser->getAvatar(),
                'estado'   => 1,
                'nombre'   => $user->nombre ?: $baseUsername, // si no tiene nombre, lo ponemos
                'apellido' => $user->apellido ?: '',          // dejamos vacío
            ]);
        } else {
            // Usuario nuevo: generar username único
            $username = $baseUsername;
            $counter = 1;

            while (User::where('username', $username)->exists()) {
                $username = $baseUsername . $counter;
                $counter++;
            }

            $user = User::create([
                'username'  => $username,
                'nombre'    => $username, 
                'apellido'  => '',        
                'email'     => $githubUser->getEmail(),
                'password'  => bcrypt(Str::random(16)),
                'estado'    => 1,
                'foto_url'  => $githubUser->getAvatar(),
                'uid'       => (string) Str::uuid(),
            ]);

            RoleUser::create([
                'user_id' => $user->id,
                'role_id' => 4,
                'estado'  => 1,
                'uid'     => Str::uuid(),
            ]);
        }

        Auth::login($user);

        return redirect('/dashboard');
    }

}
