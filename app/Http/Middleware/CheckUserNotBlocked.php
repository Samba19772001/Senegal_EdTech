<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserNotBlocked
{
    public function handle(Request $request, Closure $next)
    {
        // Ignorer toutes les routes admin
        if ($request->is('admin') || $request->is('admin/*')) {
            return $next($request);
        }

        if (Auth::guard('web')->check() && Auth::guard('web')->user()->is_blocked) {
            Auth::guard('web')->logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Votre compte a été bloqué. Contactez l\'administrateur.']);
        }

        return $next($request);
    }
}