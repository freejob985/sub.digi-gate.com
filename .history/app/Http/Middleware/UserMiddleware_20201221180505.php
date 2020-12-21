<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UserMiddleware
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
        if (Auth::check() && (isClient() || isFreelancer() || comprehensive() ) && !Auth::user()->banned) {
        //    dd("Catch errors for script and full tracking ( 1 )");
            return $next($request);
        }
        else{
          //  dd("Catch errors for script and full tracking ( 2 )");
            session(['link' => url()->current()]);
            return redirect()->route('user.login');
        }
    }
}
