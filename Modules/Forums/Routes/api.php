<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Forums\Http\Controllers\Api\MemoryApiController;
use Modules\Forums\Http\Controllers\Api\ForumPostApiController;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

Route::middleware(['auth:api'])->group(function () {

    Route::get('forum-posts', [ForumPostApiController::class, 'index']);
    Route::post('forum-posts', [ForumPostApiController::class, 'store']);
    Route::post('forum-posts/update', [ForumPostApiController::class, 'update']);
    Route::get('forum-posts/feeds', [ForumPostApiController::class, 'feeds']);
    Route::get('forum-posts/comment/{id}', [ForumPostApiController::class, 'feedComments']);
    Route::post('forum-posts/comment', [ForumPostApiController::class, 'commentStore']);
    Route::post('forum-posts/comment-reply', [ForumPostApiController::class, 'commentReplyStore']);

    Route::get('memories', [MemoryApiController::class, 'index']);
    Route::post('memories', [MemoryApiController::class, 'store']);
    Route::get('memories/{id}', [MemoryApiController::class, 'show']);
    Route::post('memories/update', [MemoryApiController::class, 'update']);

});
