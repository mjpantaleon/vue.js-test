<?php

namespace App\Http\Middleware;

use Session;
use Closure;

class CustomAuth
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
        dd(Session::all());
        if(!Session::has('user')){
            return redirect('login');
        }
        return $next($request);
    }
}
