<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!session()->has('LoggedUser') && $request->path() != 'login'){
            return redirect()->route('auth.login');
        }

        if(session()->has('LoggedUser') && $request->path() == 'login'){
            return back();
        }

        return $next($request);
    }
}
