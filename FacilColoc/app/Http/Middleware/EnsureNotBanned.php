<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureNotBanned
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isBanned()) {
            auth()->logout();

            return redirect('/')
                ->with('error', 'Votre compte a Ã©tÃ© dÃ©sactivÃ©.');
        }

        return $next($request);
    }
}

