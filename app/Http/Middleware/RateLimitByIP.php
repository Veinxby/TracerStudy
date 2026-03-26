<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class RateLimitByIP
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $ip = $request->ip();
        $key = 'rate_limit:ip:' . $ip;

        RateLimiter::hit($key, 30);

        return $next($request);
    }
}
