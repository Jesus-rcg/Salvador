<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Validar si la sesión NO tiene el usuario
        if (!$request->session()->has('user')) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión.');
        }

        return $next($request);
    }
}
