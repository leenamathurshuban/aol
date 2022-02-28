<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class EmployeeLogin
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
        if(isset(auth::guard('employee')->user()->id) && auth::guard('employee')->user()->id){
            return $next($request);
        }
        return redirect()->route('employee.login');
    }
}
