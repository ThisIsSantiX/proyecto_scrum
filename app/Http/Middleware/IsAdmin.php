<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;


class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'No estás autenticado.');
        }

        $tieneRol = DB::table('role_users')
            ->where('user_id', $user->id)
            ->where('role_id', 5) 
            ->where('estado', 1) 
            ->exists();

        if (!$tieneRol) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
