<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
use Route;
use App\Admin_role;


class CheckAdmin
{
    public function handle($request, Closure $next, $guard = null)
    {

        if (!Auth::guard($guard)->check() && $guard == "admin") {
            return redirect('admin/login');
        } else {
            if (Auth::guard('admin')->user() && Auth::guard('admin')->user()->role_id != '1') {
                if (\Request::path() != 'admin') $route = str_replace('admin/', '', \Request::path());
                else $route = 'admin';
                $newRoute = explode("/", $route);
                $newRoute = array_splice($newRoute, 0, 1);
                $access = Admin_role::where('admin_id', Auth::guard('admin')->user()->id)->where('route', $newRoute);
                // dd($newRoute);
                if ($access->count() == 0) {
                    return redirect('/admin')->with('message', 'Access is not permitted!');
                }
            }
        }

        if (!Auth::guard($guard)->check() && $guard == "user") {
            return redirect('login');
        }

        if (!Auth::guard($guard)->check() && $guard == "driver") {
            return redirect('driver/login');
        }


        return $next($request);
    }
}
