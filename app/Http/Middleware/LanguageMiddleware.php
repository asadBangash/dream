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
        $enabled = enabledLanguageCodes();
        $fallback = $enabled[0] ?? Config::get('app.locale', 'en');

        $locale = Session::get('locale');
        if (! $locale || ! in_array($locale, $enabled, true)) {
            $locale = setting('default-language');
            if (! $locale || ! in_array($locale, $enabled, true)) {
                $locale = $fallback;
            }
            Session::put('locale', $locale);
        }

        App::setLocale($locale);

        return $next($request);
    }
}
