<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check() && $guard == "admin") {
            return redirect('admin/login');
        }

        if (!Auth::guard($guard)->check() && $guard == "user") {
            return redirect('login');
        }

        return $next($request);
    }
}
