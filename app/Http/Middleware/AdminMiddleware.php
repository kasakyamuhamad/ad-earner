<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->expectsJson()) {
        return response()->json(['message' => 'Unauthorized.'], 403);
    }

        return $next($request);
    }
}
