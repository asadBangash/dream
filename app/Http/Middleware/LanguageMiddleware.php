<?php

namespace App\Http\Middleware;

use App;
use Config;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } else {
            if (setting('default-language')) {
                App::setLocale(setting('default-language'));
                Session::put('locale',setting('default-language'));
            } else {
                App::setLocale(Config::get('app.locale'));
                Session::put('locale',Config::get('app.locale'));
            }
        }

        return $next($request);
    }
}
