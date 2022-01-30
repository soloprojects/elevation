<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\Utility;
use Illuminate\Support\Facades\Auth;

class Employee
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
        if (Auth::user() && (Auth::user()->role_id == Utility::admin || Auth::user()->role_id == Utility::superAdmin || Auth::user()->role_id == Utility::company || Auth::user()->role_id == Utility::employee)) {
            return $next($request);
        }
        return redirect(route('logout'));
    }

}
