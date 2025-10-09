<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role_id != 1) {
            abort(403, 'Unauthorized Access');
        }

        return $next($request);
    }
}
