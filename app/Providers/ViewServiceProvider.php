<?php

namespace App\Providers;

use App\View\Composers\AttendanceComposer;
use App\View\Composers\LanguageComposer;
use App\View\Composers\SessionComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer('backend.partials.header', LanguageComposer::class);
        View::composer('backend.partials.header', AttendanceComposer::class);
        View::composer('student-panel.partials.header', LanguageComposer::class);
        View::composer('parent-panel.partials.header', LanguageComposer::class);
        View::composer('frontend.partials.menu', LanguageComposer::class);
        View::composer('backend.partials.header', SessionComposer::class);
        
        View::composer('mainapp::layouts.backend.header', LanguageComposer::class);
    }
}
