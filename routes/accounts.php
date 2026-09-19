<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Accounts\IncomeController;
use App\Http\Controllers\Accounts\ExpenseController;
use App\Http\Controllers\Accounts\AccountHeadController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;


Route::middleware(saasMiddleware())->group(function () {
    Route::group(['middleware' => ['XssSanitizer']], function () {
        Route::group(['middleware' => ['lang', 'CheckSubscription', 'FeatureCheck:account']], function () {
            // auth routes
            Route::group(['middleware' => ['auth.routes', 'AdminPanel']], function () {
                Route::controller(AccountHeadController::class)->prefix('account-head')->group(function () {
                    Route::get('/',                 'index')->name('account_head.index')->middleware('PermissionCheck:account_head_read');
                    Route::get('/create',           'create')->name('account_head.create')->middleware('PermissionCheck:account_head_create');
                    Route::post('/store',           'store')->name('account_head.store')->middleware('PermissionCheck:account_head_create', 'DemoCheck');
                    Route::get('/edit/{id}',        'edit')->name('account_head.edit')->middleware('PermissionCheck:account_head_update');
                    Route::put('/update/{id}',      'update')->name('account_head.update')->middleware('PermissionCheck:account_head_update', 'DemoCheck');
                    Route::delete('/delete/{id}',   'delete')->name('account_head.delete')->middleware('PermissionCheck:account_head_delete', 'DemoCheck');
                });

                Route::controller(IncomeController::class)->prefix('income')->group(function () {
                    Route::get('/',                 'index')->name('income.index')->middleware('PermissionCheck:income_read');
                    Route::get('/create',           'create')->name('income.create')->middleware('PermissionCheck:income_create');
                    Route::post('/store',           'store')->name('income.store')->middleware('PermissionCheck:income_create', 'DemoCheck');
                    Route::get('/edit/{id}',        'edit')->name('income.edit')->middleware('PermissionCheck:income_update');
                    Route::put('/update/{id}',      'update')->name('income.update')->middleware('PermissionCheck:income_update', 'DemoCheck');
                    Route::delete('/delete/{id}',   'delete')->name('income.delete')->middleware('PermissionCheck:income_delete', 'DemoCheck');
                });

                Route::controller(ExpenseController::class)->prefix('expense')->group(function () {
                    Route::get('/',                 'index')->name('expense.index')->middleware('PermissionCheck:expense_read');
                    Route::get('/create',           'create')->name('expense.create')->middleware('PermissionCheck:expense_create');
                    Route::post('/store',           'store')->name('expense.store')->middleware('PermissionCheck:expense_create', 'DemoCheck');
                    Route::get('/edit/{id}',        'edit')->name('expense.edit')->middleware('PermissionCheck:expense_update');
                    Route::put('/update/{id}',      'update')->name('expense.update')->middleware('PermissionCheck:expense_update', 'DemoCheck');
                    Route::delete('/delete/{id}',   'delete')->name('expense.delete')->middleware('PermissionCheck:expense_delete', 'DemoCheck');
                });
            });
        });
    });
});

