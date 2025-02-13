<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class UserActiveCheckMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->guest() && !auth()->user()->active) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            throw new UnauthorizedException();
        }

        return $next($request);
    }
}
