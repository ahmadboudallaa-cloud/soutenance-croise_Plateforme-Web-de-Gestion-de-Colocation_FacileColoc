<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isGlobalAdmin()) {
            abort(403, 'AccÃ¨s rÃ©servÃ© Ã  lâ€™administrateur global.');
        }

        return $next($request);
    }
}

