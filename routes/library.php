<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Library\BookController;
use App\Http\Controllers\Library\MemberController;
use App\Http\Controllers\Library\IssueBookController;
use App\Http\Controllers\Library\BookCategoryController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use App\Http\Controllers\Library\MemberCategoryController;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;


Route::middleware(saasMiddleware())->group(function () {
    Route::group(['middleware' => ['XssSanitizer']], function () {
        Route::group(['middleware' => ['lang', 'CheckSubscription', 'FeatureCheck:library']], function () {
            // auth routes
            Route::group(['middleware' => ['auth.routes', 'AdminPanel']], function () {
                Route::controller(BookCategoryController::class)->prefix('book-category')->group(function () {
                    Route::get('/',                 'index')->name('book-category.index')->middleware('PermissionCheck:book_category_read');
                    Route::get('/create',           'create')->name('book-category.create')->middleware('PermissionCheck:book_category_create');
                    Route::post('/store',           'store')->name('book-category.store')->middleware('PermissionCheck:book_category_create', 'DemoCheck');
                    Route::get('/edit/{id}',        'edit')->name('book-category.edit')->middleware('PermissionCheck:book_category_update');
                    Route::put('/update/{id}',      'update')->name('book-category.update')->middleware('PermissionCheck:book_category_update', 'DemoCheck');
                    Route::delete('/delete/{id}',   'delete')->name('book-category.delete')->middleware('PermissionCheck:book_category_delete', 'DemoCheck');
                });
                Route::controller(BookController::class)->prefix('book')->group(function () {
                    Route::get('/',                 'index')->name('book.index')->middleware('PermissionCheck:book_read');
                    Route::get('/create',           'create')->name('book.create')->middleware('PermissionCheck:book_create');
                    Route::post('/store',           'store')->name('book.store')->middleware('PermissionCheck:book_create', 'DemoCheck');
                    Route::get('/edit/{id}',        'edit')->name('book.edit')->middleware('PermissionCheck:book_update');
                    Route::put('/update/{id}',      'update')->name('book.update')->middleware('PermissionCheck:book_update', 'DemoCheck');
                    Route::delete('/delete/{id}',   'delete')->name('book.delete')->middleware('PermissionCheck:book_delete', 'DemoCheck');
                });
                Route::controller(MemberController::class)->prefix('member')->group(function () {
                    Route::get('/',                 'index')->name('member.index')->middleware('PermissionCheck:member_read');
                    Route::get('/create',           'create')->name('member.create')->middleware('PermissionCheck:member_create');
                    Route::post('/store',           'store')->name('member.store')->middleware('PermissionCheck:member_create', 'DemoCheck');
                    Route::get('/edit/{id}',        'edit')->name('member.edit')->middleware('PermissionCheck:member_update');
                    Route::put('/update/{id}',      'update')->name('member.update')->middleware('PermissionCheck:member_update', 'DemoCheck');
                    Route::delete('/delete/{id}',   'delete')->name('member.delete')->middleware('PermissionCheck:member_delete', 'DemoCheck');
                    Route::get('/get-member',       'getMember');
                });
                Route::controller(IssueBookController::class)->prefix('issue-book')->group(function () {
                    Route::get('/',                 'index')->name('issue-book.index')->middleware('PermissionCheck:issue_book_read');
                    Route::get('/create',           'create')->name('issue-book.create')->middleware('PermissionCheck:issue_book_create');
                    Route::post('/store',           'store')->name('issue-book.store')->middleware('PermissionCheck:issue_book_create', 'DemoCheck');
                    Route::get('/edit/{id}',        'edit')->name('issue-book.edit')->middleware('PermissionCheck:issue_book_update');
                    Route::put('/update/{id}',      'update')->name('issue-book.update')->middleware('PermissionCheck:issue_book_update', 'DemoCheck');
                    Route::delete('/delete/{id}',   'delete')->name('issue-book.delete')->middleware('PermissionCheck:issue_book_delete', 'DemoCheck');
                    Route::get('/return/{id}',      'return')->name('issue-book.return')->middleware('PermissionCheck:issue_book_update');
                    Route::any('/search',           'search')->name('issue-book.search')->middleware('PermissionCheck:issue_book_read');
                    Route::get('/get-member',       'getMember');
                    Route::get('/get-book',         'getBook');
                });
                Route::controller(MemberCategoryController::class)->prefix('member-category')->group(function () {
                    Route::get('/',                 'index')->name('member-category.index')->middleware('PermissionCheck:member_category_read');
                    Route::get('/create',           'create')->name('member-category.create')->middleware('PermissionCheck:member_category_create');
                    Route::post('/store',           'store')->name('member-category.store')->middleware('PermissionCheck:member_category_create', 'DemoCheck');
                    Route::get('/edit/{id}',        'edit')->name('member-category.edit')->middleware('PermissionCheck:member_category_update');
                    Route::put('/update/{id}',      'update')->name('member-category.update')->middleware('PermissionCheck:member_category_update', 'DemoCheck');
                    Route::delete('/delete/{id}',   'delete')->name('member-category.delete')->middleware('PermissionCheck:member_category_delete', 'DemoCheck');
                });
    
            });
        });
    });
});

