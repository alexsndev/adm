<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestrictClientAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_client) {
            // Permitir apenas rotas que começam com 'cliente'
            if (!str_starts_with($request->path(), 'cliente')) {
                abort(403, 'Acesso não autorizado');
            }
        }
        return $next($request);
    }
} 