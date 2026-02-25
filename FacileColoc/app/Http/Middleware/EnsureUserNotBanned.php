<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserNotBanned
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isBanned()) {
            Auth::logout();

            return redirect('/login')
                ->withErrors([
                    'email' => 'Votre compte est bloqué. Contactez l’administration.',
                ]);
        }

        return $next($request);
    }
}