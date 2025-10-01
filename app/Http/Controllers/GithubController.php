<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

        // Buscar o crear usuario en la BD
        $user = User::firstOrCreate(
            ['email' => $githubUser->getEmail()],
            [
                'username' => $githubUser->getNickname() ?? $githubUser->getId(),
                'password' => bcrypt(str()->random(16)), // random porque no inicia con clave
                'estado' => 1,
                'foto_url' => $githubUser->getAvatar(),
                'uid' => (string) \Illuminate\Support\Str::uuid(),
            ]
        );

        // Si existo
        // Iniciar sesión en Laravel
        Auth::login($user);

        return redirect('/dashboard'); // Redirige donde quieras
    }
}
