<?php

use Illuminate\Support\Facades\Route;
use Modules\MultiBranch\Http\Controllers\BranchController;
use Modules\MultiBranch\Http\Controllers\MultiBranchController;

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

Route::middleware(saasMiddleware())->group(function () {
    Route::resource('multibranch', MultiBranchController::class)->names('multibranch');

    Route::prefix('branches')
    ->as('branch.')
    ->controller(BranchController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('{id}/edit', 'edit')->name('edit');
        Route::put('{id}/update', 'update')->name('update');
        Route::delete('delete/{id}', 'destroy')->name('destroy');
    });

Route::get('switch-branch', [MultiBranchController::class, 'switchBranch'])->name('switch-branch');
});


