<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
         if ($guard == "employee" && Auth::guard($guard)->check()) {
                return redirect()->route('employee.home');
            }
            if ($guard == "vendor" && Auth::guard($guard)->check()) {
                return redirect()->route('vendor.home');
            }
            if (Auth::guard($guard)->check()) {
                return redirect()->route('admin.home');
            }

            return $next($request);
        /*if (Auth::guard($guard)->check()) {
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);*/
    }
}
