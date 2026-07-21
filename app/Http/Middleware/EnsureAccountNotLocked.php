<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountNotLocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && session('account_locked', false) === true) {
            // Allow access to lock screen routes and logout
            if (!$request->routeIs('lock-screen*') && !$request->routeIs('logout')) {
                return redirect()->route('lock-screen');
            }
        }

        return $next($request);
    }
}
