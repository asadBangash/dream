<?php

use Illuminate\Support\Facades\Route;
use Modules\Forums\Http\Controllers\ForumsController;
use Modules\Forums\Http\Controllers\MemoryController;

Route::middleware(saasMiddleware())->group(function () {
    Route::group(['middleware' => ['XssSanitizer']], function () {
        Route::group(['middleware' => ['lang', 'CheckSubscription', 'FeatureCheck:account']], function () {
            // auth routes
            Route::group(['middleware' => ['auth.routes', 'AdminPanel']], function () {
                Route::controller(ForumsController::class)->prefix('forums')->group(function () {
                    Route::get('/my-index', 'myIndex')->name('my-forum.index')->middleware('PermissionCheck:forum_list');
                    Route::get('/index', 'index')->name('forum.index')->middleware('PermissionCheck:forum_list');
                    Route::get('/create', 'create')->name('forum.create')->middleware('PermissionCheck:forum_create');
                    Route::post('/store', 'store')->name('forum.store')->middleware('PermissionCheck:forum_create');
                    Route::get('/edit/{id}', 'edit')->name('forum.edit')->middleware('PermissionCheck:forum_update');
                    Route::put('/update/{id}', 'update')->name('forum.update')->middleware('PermissionCheck:forum_update');
                    Route::get('/show/{id}', 'show')->name('forum.show')->middleware('PermissionCheck:forum_list');
                    Route::delete('/delete/{id}', 'destroy')->name('forum.delete')->middleware('PermissionCheck:forum_delete');
                    Route::get('/change-status/{id}', 'changeStatus')->name('forum.changeStatus')->middleware('PermissionCheck:forum_update');
                    Route::post('/comment-reply', 'commentReply')->name('forum.comment.reply')->middleware('PermissionCheck:forum_comment_create');
                    Route::delete('/comment-delete/{id}', 'commentDelete')->name('forum.comment.delete')->middleware('PermissionCheck:forum_comment_delete');
                    Route::get('/feeds', 'feeds')->name('forum.feeds')->middleware('PermissionCheck:forum_feeds');
                    Route::post('forum-posts/comment', 'commentStore')->name('forum.comment.store')->middleware('PermissionCheck:forum_comment_create');
                });

                Route::controller(MemoryController::class)->prefix('memories')->group(function () {
                    Route::get('/index', 'index')->name('memory.index')->middleware('PermissionCheck:memory_list');
                    Route::get('/my-index', 'myIndex')->name('memory.myIndex')->middleware('PermissionCheck:memory_list');
                    Route::get('/create', 'create')->name('memory.create')->middleware('PermissionCheck:memory_create');
                    Route::post('/store', 'store')->name('memory.store')->middleware('PermissionCheck:memory_create');
                    Route::get('/edit/{id}', 'edit')->name('memory.edit')->middleware('PermissionCheck:memory_update');
                    Route::put('/update/{id}', 'update')->name('memory.update')->middleware('PermissionCheck:memory_update');
                    Route::get('/show/{id}', 'show')->name('memory.show')->middleware('PermissionCheck:memory_list');
                    Route::delete('/delete/{id}', 'destroy')->name('memory.delete')->middleware('PermissionCheck:memory_delete');
                    Route::delete('/image/delete/{id}', 'deleteGalleryImage')->name('memory.image.delete')->middleware('PermissionCheck:memory_delete');
                    Route::get('/change-status/{id}', 'changeStatus')->name('memory.changeStatus')->middleware('PermissionCheck:memory_update');
                });
            });


            Route::group(['middleware' => ['auth.routes', 'StudentPanel']], function () {
                Route::controller(ForumsController::class)->prefix('student/forum')->group(function () {
                    Route::get('/index', 'indexStudent')->name('student-panel-forum.index');
                    Route::get('/create', 'createStudent')->name('student-panel-forum.create');
                    Route::post('/store', 'storeStudent')->name('student-panel-forum.store');
                    Route::get('/edit/{id}', 'editStudent')->name('student-panel-forum.edit');
                    Route::put('/update/{id}', 'updateStudent')->name('student-panel-forum.update');
                    Route::get('/show/{id}', 'showStudent')->name('student-panel-forum.show');
                    Route::delete('/delete/{id}', 'destroy')->name('student-panel-forum.delete');
                    Route::get('/change-status/{id}', 'changeStatus')->name('student-panel-forum.changeStatus');
                    Route::post('/comment-reply', 'commentReply')->name('student-panel-forum.comment.reply');
                    Route::delete('/comment-delete/{id}', 'commentDelete')->name('student-panel-forum.comment.delete');
                    Route::get('/feeds', 'feedsStudent')->name('student-panel-forum.feeds');
                    Route::post('forum-posts/comment', 'commentStore')->name('student-panel-forum.comment.store');

                });

                Route::controller(MemoryController::class)->prefix('student/memories')->group(function () {
                    Route::get('/index', 'indexStudent')->name('student-panel-memory.index');
                    Route::get('/create', 'createStudent')->name('student-panel-memory.create');
                    Route::post('/store', 'storeStudent')->name('student-panel-memory.store');
                    Route::get('/edit/{id}', 'editStudent')->name('student-panel-memory.edit');
                    Route::put('/update/{id}', 'updateStudent')->name('student-panel-memory.update');
                    Route::get('/show/{id}', 'showStudent')->name('student-panel-memory.show');
                    Route::delete('/delete/{id}', 'destroy')->name('student-panel-memory.delete');
                    Route::delete('/image/delete/{id}', 'deleteGalleryImage')->name('student-panel-memory.image.delete');
                    Route::get('/change-status/{id}', 'changeStatus')->name('student-panel-memory.changeStatus');
                });

            });
            Route::group(['middleware' => ['auth.routes', 'ParentPanel']], function () {
                Route::controller(ForumsController::class)->prefix('parent/forum')->group(function () {
                    Route::get('/index', 'indexParent')->name('parent-panel-forum.index');
                    Route::get('/create', 'createParent')->name('parent-panel-forum.create');
                    Route::post('/store', 'storeParent')->name('parent-panel-forum.store');
                    Route::get('/edit/{id}', 'editParent')->name('parent-panel-forum.edit');
                    Route::put('/update/{id}', 'updateParent')->name('parent-panel-forum.update');
                    Route::get('/show/{id}', 'showParent')->name('parent-panel-forum.show');
                    Route::delete('/delete/{id}', 'destroy')->name('parent-panel-forum.delete');
                    Route::get('/change-status/{id}', 'changeStatus')->name('parent-panel-forum.changeStatus');
                    Route::post('/comment-reply', 'commentReply')->name('parent-panel-forum.comment.reply');
                    Route::delete('/comment-delete/{id}', 'commentDelete')->name('parent-panel-forum.comment.delete');
                    Route::get('/feeds', 'feedsParent')->name('parent-panel-forum.feeds');
                    Route::post('forum-posts/comment', 'commentStore')->name('parent-panel-forum.comment.store');
                });

                Route::controller(MemoryController::class)->prefix('parent/memories')->group(function () {
                    Route::get('/index', 'indexParent')->name('parent-panel-memory.index');
                    Route::get('/create', 'createParent')->name('parent-panel-memory.create');
                    Route::post('/store', 'storeParent')->name('parent-panel-memory.store');
                    Route::get('/edit/{id}', 'editParent')->name('parent-panel-memory.edit');
                    Route::put('/update/{id}', 'updateParent')->name('parent-panel-memory.update');
                    Route::get('/show/{id}', 'showParent')->name('parent-panel-memory.show');
                    Route::delete('/delete/{id}', 'destroy')->name('parent-panel-memory.delete');
                    Route::delete('/image/delete/{id}', 'deleteGalleryImage')->name('parent-panel-memory.image.delete');
                    Route::get('/change-status/{id}', 'changeStatus')->name('parent-panel-memory.changeStatus');
                });
            });
        });
    });
});
