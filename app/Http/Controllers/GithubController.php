<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


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

        // Separar nombre completo en nombre y apellido (si existe)
        $fullName   = $githubUser->getName() ?? '';
        $nameParts  = $fullName ? explode(' ', $fullName, 2) : [];

        $nombre   = $nameParts[0] ?? '';
        $apellido = $nameParts[1] ?? '';

        // Buscar si el usuario ya existe por email
        $user = User::where('email', $githubUser->getEmail())->first();

        if ($user) {
            // Usuario existe: actualizar datos de GitHub (sin cambiar username)
            $user->update([
                'foto_url' => $githubUser->getAvatar(),
                'estado'   => 1,
                'nombre'   => $nombre ?: $user->nombre,
                'apellido' => $apellido ?: $user->apellido,
            ]);
        } else {
            // Usuario nuevo: generar username único
            $baseUsername = $githubUser->getNickname() ?? 'user' . $githubUser->getId();
            $username = $baseUsername;
            $counter = 1;

            while (User::where('username', $username)->exists()) {
                $username = $baseUsername . $counter;
                $counter++;
            }

            $user = User::create([
                'username'  => $username,
                'nombre'    => $nombre,
                'apellido'  => $apellido,
                'email'     => $githubUser->getEmail(),
                'password'  => bcrypt(Str::random(16)),
                'estado'    => 1,
                'foto_url'  => $githubUser->getAvatar(),
                'uid'       => (string) Str::uuid(),
            ]);
        }

        Auth::login($user);

        return redirect('/dashboard');
    }
}
