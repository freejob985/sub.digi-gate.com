<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Session;
use Config;

class Language
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
        if(Session::has('locale')){
            //dd("Catch errors for script and full tracking ( 1 )");
            $locale = Session::get('locale', Config::get('app.locale'));
        }
        else{
           // dd("Catch errors for script and full tracking ( 2 )");
            $locale = 'sa';
        }

        App::setLocale($locale);
        return $next($request);
    }
}
