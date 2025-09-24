<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect based on route prefix
                if ($request->is('admin/*') || $request->routeIs('admin.*')) {
                    return redirect('/admin/dashboard');
                }

                // Default redirect for normal users
                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
