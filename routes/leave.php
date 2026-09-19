<?php

use App\Http\Controllers\Leave\LeaveTypeController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth.routes', 'AdminPanel']], function () {
    Route::controller(LeaveTypeController::class)->prefix('leave-type')->group(function () {
        Route::get('/', 'index')->name('leave-type.index');
        Route::get('/create', 'create')->name('leave-type.create')->middleware('PermissionCheck:leave_type_create');
        Route::post('/store', 'store')->name('leave-type.store')->middleware('PermissionCheck:leave_type_create');
        Route::get('/edit/{id}', 'edit')->name('leave-type.edit')->middleware('PermissionCheck:leave_type_update');

    });
});

