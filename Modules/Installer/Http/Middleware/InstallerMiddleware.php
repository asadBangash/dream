<?php

namespace Modules\Installer\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class InstallerMiddleware
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
        $allFilesExist = AuthPermitCheck();

        $allowedUrls = allowedUrls();
        $currentUrl = URL::current();

        if ($allFilesExist && in_array($currentUrl, $allowedUrls)) {
            return redirect('/');
        }

        if (!in_array($currentUrl, $allowedUrls) && !$allFilesExist) {
            if (strpos($currentUrl, URL::route('service.install')) === false) {
                return redirect()->route('service.install');
            }
            if (strpos($currentUrl, URL::route('service.install')) !== false) {
                return $next($request);
            }
            abort(403);
        }

        return $next($request);
    }
}
