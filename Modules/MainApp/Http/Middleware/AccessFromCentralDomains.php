<?php

namespace Modules\MainApp\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AccessFromCentralDomains
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public static $abortRequest;
    
    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->getHost(), config('tenancy.central_domains'))) {
            return $next($request);
        }
        else {
            $abortRequest = static::$abortRequest ?? function () {
                abort(404);
            };

            return $abortRequest($request, $next);
        }

    }
}
