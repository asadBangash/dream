<?php

use App\Http\Controllers\FeesDiscountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Fees\FeesTypeController;
use App\Http\Controllers\Fees\FeesGroupController;
use App\Http\Controllers\Fees\FeesAssignController;
use App\Http\Controllers\Fees\FeesMasterController;
use App\Http\Controllers\Fees\FeesCollectController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;


Route::middleware(saasMiddleware())->group(function () {
    Route::group(['middleware' => ['XssSanitizer']], function () {
        Route::group(['middleware' => ['lang', 'CheckSubscription', 'FeatureCheck:fees']], function () {
            // auth routes
            Route::group(['middleware' => ['auth.routes', 'AdminPanel']], function () {
                Route::controller(FeesGroupController::class)->prefix('fees-group')->group(function () {
                    Route::get('/',                 'index')->name('fees-group.index')->middleware('PermissionCheck:fees_group_read');
                    Route::get('/create',           'create')->name('fees-group.create')->middleware('PermissionCheck:fees_group_create');
                    Route::post('/store',           'store')->name('fees-group.store')->middleware('PermissionCheck:fees_group_create', 'DemoCheck');
                    Route::get('/edit/{id}',        'edit')->name('fees-group.edit')->middleware('PermissionCheck:fees_group_update');
                    Route::put('/update/{id}',      'update')->name('fees-group.update')->middleware('PermissionCheck:fees_group_update', 'DemoCheck');
                    Route::delete('/delete/{id}',   'delete')->name('fees-group.delete')->middleware('PermissionCheck:fees_group_delete', 'DemoCheck');
                });

                Route::controller(FeesTypeController::class)->prefix('fees-type')->group(function () {
                    Route::get('/',                 'index')->name('fees-type.index')->middleware('PermissionCheck:fees_type_read');
                    Route::get('/create',           'create')->name('fees-type.create')->middleware('PermissionCheck:fees_type_create');
                    Route::post('/store',           'store')->name('fees-type.store')->middleware('PermissionCheck:fees_type_create', 'DemoCheck');
                    Route::get('/edit/{id}',        'edit')->name('fees-type.edit')->middleware('PermissionCheck:fees_type_update');
                    Route::put('/update/{id}',      'update')->name('fees-type.update')->middleware('PermissionCheck:fees_type_update', 'DemoCheck');
                    Route::delete('/delete/{id}',   'delete')->name('fees-type.delete')->middleware('PermissionCheck:fees_type_delete', 'DemoCheck');
                });

                Route::controller(FeesMasterController::class)->prefix('fees-master')->group(function () {
                    Route::get('/',                 'index')->name('fees-master.index')->middleware('PermissionCheck:fees_master_read');
                    Route::get('/create',           'create')->name('fees-master.create')->middleware('PermissionCheck:fees_master_create');
                    Route::post('/store',           'store')->name('fees-master.store')->middleware('PermissionCheck:fees_master_create', 'DemoCheck');
                    Route::get('/edit/{id}',        'edit')->name('fees-master.edit')->middleware('PermissionCheck:fees_master_update');
                    Route::put('/update/{id}',      'update')->name('fees-master.update')->middleware('PermissionCheck:fees_master_update', 'DemoCheck');
                    Route::delete('/delete/{id}',   'delete')->name('fees-master.delete')->middleware('PermissionCheck:fees_master_delete', 'DemoCheck');
                    Route::get('/get-all-type',     'getAllTypes');
                });

                Route::controller(FeesAssignController::class)->prefix('fees-assign')->group(function () {
                    Route::get('/',                 'index')->name('fees-assign.index')->middleware('PermissionCheck:fees_assign_read');
                    Route::get('/create',           'create')->name('fees-assign.create')->middleware('PermissionCheck:fees_assign_create');
                    Route::post('/store',           'store')->name('fees-assign.store')->middleware('PermissionCheck:fees_assign_create', 'DemoCheck');
                    Route::get('/edit/{id}',        'edit')->name('fees-assign.edit')->middleware('PermissionCheck:fees_assign_update');
                    Route::put('/update/{id}',      'update')->name('fees-assign.update')->middleware('PermissionCheck:fees_assign_update', 'DemoCheck');
                    Route::delete('/delete/{id}',   'delete')->name('fees-assign.delete')->middleware('PermissionCheck:fees_assign_delete', 'DemoCheck');
                    Route::get('/show',              'show');

                    Route::get('/get-all-type',     'getAllTypes');

                    Route::get('/get-fees-assign-students',  'getFeesAssignStudents');
                    Route::get('/import', 'import')->name('fees-assign.import')->middleware('PermissionCheck:fees_assign_create');
                    Route::post('/import-submit', 'importSubmit')->name('fees-assign.importSubmit')->middleware('PermissionCheck:fees_assign_create');
                    Route::get('/sample-download',          'sampleDownload')->name('fees-assign.sampleDownload')->middleware('PermissionCheck:fees_assign_create');
                });

                Route::controller(FeesCollectController::class)->prefix('fees-collect')->group(function () {
                    Route::get('/',                 'index')->name('fees-collect.index')->middleware('PermissionCheck:fees_collect_read');
                    Route::get('/create',           'create')->name('fees-collect.create')->middleware('PermissionCheck:fees_collect_create');
                    Route::post('/store',           'store')->name('fees-collect.store')->middleware('PermissionCheck:fees_collect_create', 'DemoCheck');
                    Route::get('/edit/{id}',        'edit')->name('fees-collect.edit')->middleware('PermissionCheck:fees_collect_update');
                    Route::put('/update/{id}',      'update')->name('fees-collect.update')->middleware('PermissionCheck:fees_collect_update', 'DemoCheck');
                    Route::delete('/delete/{id}',   'delete')->name('fees-collect.delete')->middleware('PermissionCheck:fees_collect_delete', 'DemoCheck');
                    Route::get('/collect/{id}',     'collect')->name('fees-collect.collect')->middleware('PermissionCheck:fees_collect_update');


                    Route::any('/search', 'getFeesCollectStudents')->name('fees-collect-search');
                    Route::get('/fees-show', 'feesShow');
                });

                Route::controller(FeesDiscountController::class)->prefix('fees-discount')->group(function () {
                    Route::get('/',                 'index')->name('fees-discount.index')->middleware('PermissionCheck:siblings_discount');
                    Route::post('/store',           'store')->name('fees-discount.store')->middleware('PermissionCheck:siblings_discount');
                    Route::post('/early-payment-discount', 'storeEarlyPaymentDiscount')->name('fees-discount.early-payment-discount')->middleware('PermissionCheck:early_payment_discount');
                    Route::post('/toggle-applicable', 'toggleApplicable')->name('fees-discount.toggle-applicable');
                    Route::post('/early-payment-toggle', 'toggleEarlyPayment')->name('fees-discount.early-payment-toggle');
                });
            });
        });
    });
});


