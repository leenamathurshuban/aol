<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class VendorLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(isset(Auth::guard('vendor')->user()->id) && Auth::guard('vendor')->user()->id){
            return $next($request);
        }
        return redirect()->route('vendor.login');
    }
}
