<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $type)
    {
        if (auth()->user()->user_type == $type) {
            return $next($request);
        }

        elseif (auth()->user()->user_type == $type) {
            return $next($request);
        }

        elseif (auth()->user()->user_type == $type) {
            return $next($request);
        }
        return redirect('/')->with('error', "No access.");
    }
}
