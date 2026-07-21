<?php

namespace App\Http\Middleware;

use App\Models\Admin\System\AppFeature;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If maintenance_mode feature flag is inactive, proceed normally
        if (!AppFeature::isEnabled('maintenance_mode', false)) {
            return $next($request);
        }

        // Allow authenticated Admin users full access
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                return $next($request);
            }

            // Non-admin user: logout and show maintenance page
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->view('errors.maintenance', [], 503);
        }

        // Allow access to login/logout routes so Admin can authenticate
        if ($request->is('login') || $request->routeIs('login') || $request->is('logout') || $request->routeIs('logout')) {
            return $next($request);
        }

        // Display Maintenance page for all other guest requests
        return response()->view('errors.maintenance', [], 503);
    }
}
