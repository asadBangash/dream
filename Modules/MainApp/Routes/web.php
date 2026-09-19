<?php

use App\Enums\Status;
use Modules\MainApp\Entities\School;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Request;
use Modules\MainApp\Http\Controllers\FAQController;
use Modules\MainApp\Http\Controllers\ReportController;
use Modules\MainApp\Http\Controllers\SchoolController;
use Modules\MainApp\Http\Controllers\FeatureController;
use Modules\MainApp\Http\Controllers\MainAppController;
use Modules\MainApp\Http\Controllers\PackageController;
use Modules\MainApp\Http\Controllers\SettingController;
use Modules\MainApp\Http\Controllers\LanguageController;
use Modules\MainApp\Http\Controllers\SectionsController;
use Modules\MainApp\Http\Controllers\DashboardController;
use Modules\MainApp\Http\Controllers\MyProfileController;
use Modules\MainApp\Http\Controllers\TestimonialController;
use Modules\MainApp\Http\Controllers\SubscriptionController;
use Modules\MainApp\Http\Middleware\AccessFromCentralDomains;
use Modules\MainApp\Http\Controllers\AuthenticationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Non-auth routes

if (Request::getHost() == env('APP_MAIN_APP_URL') && env('APP_SAAS')) {


    Route::middleware([
        'web',
        AccessFromCentralDomains::class,
    ])->group(function () {

        Route::get('/',               [MainAppController::class, 'index'])->name('Home');
        Route::group(['middleware' => ['not.auth.routes']], function () {
            Route::get('/login',      [AuthenticationController::class, 'loginPage'])->name('login');
            Route::post('/login',     [AuthenticationController::class, 'login'])->name('login-auth');
        });

        Route::post('/contact',                  [MainAppController::class, 'storeContact'])->name('contact');
        Route::post('/subscribe',                [MainAppController::class, 'storeSubscribe'])->name('subscribe');
        Route::post('/check-sub-domain',         [MainAppController::class, 'checkSubDomain'])->name('check-sub-domain');
        Route::get('/upgrade-subscription/{plan_id}/{subdomain_name}', [MainAppController::class, 'upgradeSubscription'])->name('upgrade-subscription');
        Route::get('/purchase-subscription/{id}',                      [MainAppController::class, 'subscription'])->name('purchase-subscription');
        Route::post('/purchase-subscription',    [MainAppController::class, 'subscriptionStore'])->name('purchase-subscription.store');
        Route::post('/pay-with-paypal',          [MainAppController::class, 'payWithPaypal'])->name('pay-with-paypal');
        Route::get('/payment-success',           [MainAppController::class, 'paymentSuccess'])->name('payment.success');
        Route::get('/payment-cancel',            [MainAppController::class, 'paymentCancel'])->name('payment.cancel');
        Route::get('/purchase-invoice',          [MainAppController::class, 'purchaseInvoice'])->name('purchase-invoice');
        Route::get('/download-invoice',          [MainAppController::class, 'downloadInvoice'])->name('download-invoice');
        Route::post('/upgrade-subscription',    [MainAppController::class, 'upgradeSubscriptionStore'])->name('upgrade-subscription.store');

        // auth routes
        Route::group(['middleware' =>   ['auth.routes']], function () {

            Route::post('logout',       [AuthenticationController::class, 'logout'])->name('logout');
            Route::group(['middleware' => 'AdminPanel'], function () {
                Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
            });

            Route::get('/contacts',     [MainAppController::class, 'getContacts'])->name('contacts');
            Route::get('/subscribes',   [MainAppController::class, 'getSubscribes'])->name('subscribes');

            Route::controller(SchoolController::class)->prefix('school')->group(function () {
                Route::get('/',                 'index')->name('school.index');
                Route::get('/create',           'create')->name('school.create');
                Route::post('/store',           'store')->name('school.store');
                Route::get('/edit/{id}',        'edit')->name('school.edit');
                Route::put('/update/{id}',      'update')->name('school.update');
                Route::delete('/delete/{id}',   'delete')->name('school.delete');
            });

            Route::controller(SubscriptionController::class)->prefix('subscription')->group(function () {
                Route::get('/',                 'index')->name('subscription.index');
                Route::get('/edit/{id}',        'edit')->name('subscription.edit');
                Route::put('/approved/{id}',    'approved')->name('subscription.approved');
                Route::get('/reject/{id}',      'reject')->name('subscription.reject');
                Route::delete('/delete/{id}',   'delete')->name('subscription.delete');

                Route::get('/create',           'create')->name('subscription.create');
                Route::post('/store',           'store')->name('subscription.store');
            });

            Route::controller(FeatureController::class)->prefix('feature')->group(function () {
                Route::get('/',                 'index')->name('feature.index');
                // Route::get('/create',           'create')->name('feature.create');
                Route::post('/store',           'store')->name('feature.store');
                Route::get('/edit/{id}',        'edit')->name('feature.edit');
                Route::put('/update/{id}',      'update')->name('feature.update');
                // Route::delete('/delete/{id}',   'delete')->name('feature.delete');
            });

            Route::controller(TestimonialController::class)->prefix('testimonial')->group(function () {
                Route::get('/',                 'index')->name('testimonial.index');
                Route::get('/create',           'create')->name('testimonial.create');
                Route::post('/store',           'store')->name('testimonial.store');
                Route::get('/edit/{id}',        'edit')->name('testimonial.edit');
                Route::put('/update/{id}',      'update')->name('testimonial.update');
                Route::delete('/delete/{id}',   'delete')->name('testimonial.delete');
            });

            Route::controller(FAQController::class)->prefix('faq')->group(function () {
                Route::get('/',                 'index')->name('faq.index');
                Route::get('/create',           'create')->name('faq.create');
                Route::post('/store',           'store')->name('faq.store');
                Route::get('/edit/{id}',        'edit')->name('faq.edit');
                Route::put('/update/{id}',      'update')->name('faq.update');
                Route::delete('/delete/{id}',   'delete')->name('faq.delete');
            });

            Route::controller(PackageController::class)->prefix('package')->group(function () {
                Route::get('/',                 'index')->name('package.index');
                Route::get('/create',           'create')->name('package.create');
                Route::post('/store',           'store')->name('package.store');
                Route::get('/edit/{id}',        'edit')->name('package.edit');
                Route::put('/update/{id}',      'update')->name('package.update');
                Route::delete('/delete/{id}',   'delete')->name('package.delete');
            });


            Route::controller(ReportController::class)->prefix('payment-report')->group(function () {
                Route::get('/',                 'index')->name('payment.report.index');
                Route::any('/search',                'search')->name('payment.report.search');
            });

            Route::controller(SectionsController::class)->prefix('sections')->group(function () {
                Route::get('/',                  'index')->name('sections.index');
                Route::get('/edit/{id}',         'edit')->name('sections.edit');
                Route::put('/update/{id}',       'update')->name('sections.update');
                Route::get('/add-social-link',   'addSocialLink');
            });

            Route::controller(MyProfileController::class)->group(function () {
                Route::get('/profile',              'profile')->name('profile');
                Route::get('/profile/edit',         'edit')->name('profile.edit');
                Route::put('/profile/update',       'update')->name('profile.update');
                Route::get('/password/update',      'passwordUpdate')->name('password-update');
                Route::put('/password/update/store', 'passwordUpdateStore')->name('password-update-store');
            });

            Route::controller(SettingController::class)->prefix('/')->group(function () {
                Route::get('/general-settings',  'generalSettings')->name('settings.general-settings');
                Route::post('/general-settings', 'updateGeneralSetting')->name('settings.general-settings');
            });

            Route::controller(LanguageController::class)->prefix('languages')->group(function () {
                Route::get('/',                   'index')->name('languages.index');
                Route::get('/create',             'create')->name('languages.create');
                Route::post('/store',             'store')->name('languages.store');
                Route::get('/edit/{id}',          'edit')->name('languages.edit');
                Route::put('/update/{id}',        'update')->name('languages.update');
                Route::delete('/delete/{id}',     'delete')->name('languages.delete');

                Route::get('/terms/{id}',         'terms')->name('languages.edit.terms');
                Route::put('/update/terms/{code}', 'termsUpdate')->name('languages.update.terms');
                Route::get('/change-module',      'changeModule')->name('languages.change.module');
                Route::get('/fetch-terms', [LanguageController::class, 'fetchTerms'])->name('languages.fetch.terms');

            });
        });
    });
}
else
{
    $subdomainParts = getSubdomainName();
    if (@$subdomainParts[1] == env('APP_MAIN_APP_URL') && Schema::hasTable('schools')) {
        $school = School::where('sub_domain_key', $subdomainParts[0])->first();
        if (!$school || $school->status == Status::INACTIVE) {
            abort(404);
        }
    }
}
