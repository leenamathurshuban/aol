<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
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
        //if(isset(auth()->user()->is_admin) && (auth()->user()->is_admin == 1)){
        if(isset(auth()->user()->id) && auth()->user()->id){
            return $next($request);
        }
        return redirect()->route('admin.login');
    }
}
