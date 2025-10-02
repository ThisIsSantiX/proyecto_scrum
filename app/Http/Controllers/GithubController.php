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

        // Buscar si el usuario ya existe por email
        $user = User::where('email', $githubUser->getEmail())->first();

        if ($user) {
            // Usuario existe: SOLO actualizar datos de GitHub
            $user->update([
                'foto_url' => $githubUser->getAvatar(),
                'estado' => 1,
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
                'username' => $username,
                'email' => $githubUser->getEmail(),
                'password' => bcrypt(Str::random(16)),
                'estado' => 1,
                'foto_url' => $githubUser->getAvatar(),
                'uid' => (string) Str::uuid(),
            ]);
        }

        Auth::login($user);

        return redirect('/dashboard');
    }
}
