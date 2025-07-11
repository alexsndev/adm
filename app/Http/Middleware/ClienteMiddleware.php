<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Supondo que o campo is_client identifica o usuário cliente
        if (!Auth::check() || !Auth::user()->is_client) {
            return redirect('/');
        }
        return $next($request);
    }
} 