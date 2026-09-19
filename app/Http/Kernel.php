<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \Modules\Installer\Http\Middleware\InstallerMiddleware::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \App\Http\Middleware\AllowOrigin::class,



    ];


    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\CustomThrottleRequests::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class,
            \App\Http\Middleware\SetAppTimezone::class,
        ],
        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'auth.routes' => \App\Http\Middleware\AuthenticateRoutes::class,
        'not.auth.routes' => \App\Http\Middleware\NotAuthenticateRoutes::class,
        'lang' => \App\Http\Middleware\LanguageMiddleware::class,
        'PermissionCheck' => \App\Http\Middleware\PermissionCheck::class,
        'FeatureCheck' => \App\Http\Middleware\FeatureCheck::class,
        'XssSanitizer' => \App\Http\Middleware\XssSanitization::class,
        'AdminPanel' => \App\Http\Middleware\AdminPanel::class,
        'StudentPanel' => \App\Http\Middleware\StudentPanel::class,
        'ParentPanel' => \App\Http\Middleware\ParentPanel::class,
        'DemoCheck' => \App\Http\Middleware\DemoCheckMiddleware::class,
        'CheckSubscription' => \App\Http\Middleware\CheckSubscriptionMiddleware::class,
        'instructor' => \App\Http\Middleware\InstructorMiddleware::class,
        'student' => \App\Http\Middleware\StudentMiddleware::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'guardian' => \App\Http\Middleware\GuardianMiddleware::class,
        'throttleweb' => \App\Http\Middleware\CustomThrottleRequests::class,


    ];
}
