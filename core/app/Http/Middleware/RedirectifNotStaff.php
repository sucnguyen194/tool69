<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectifNotStaff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,  $guard='staff')
    {
        if(!Auth::guard($guard)->check()) {
            return redirect()->route('staff.login');
        }
        return $next($request);
    }
}
