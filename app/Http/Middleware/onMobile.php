<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class onMobile
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
        if (str_contains(request()->userAgent(), "Mobile")) {
            return redirect()->back();
        } else {
            return $next($request);
        }
    }
}
