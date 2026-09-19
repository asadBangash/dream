<?php

use Illuminate\Support\Facades\Route;
use Modules\LiveChat\Http\Controllers\LiveChatController;
use Modules\LiveChat\Http\Controllers\MessageController;
use Modules\LiveChat\Http\Controllers\ConversationController;

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

    Route::prefix('admin')->middleware(['auth.routes'],)->group(function () {
        Route::controller(LiveChatController::class)->group(function () {
            Route::get('/live-chat', 'index')->name('livechat.index')->middleware('PermissionCheck:livechat_read');
            Route::get('/live-chat-settings', 'setting')->name('livechat.setting')->middleware('PermissionCheck:livechat_settings');
            Route::post('/live-chat-settings', 'settingUpdate')->name('livechat.setting.update')->middleware('PermissionCheck:livechat_settings');
            Route::get('/chat-list', 'chatList')->name('livechat.chat_list');
        });
        Route::controller(MessageController::class)->group(function () {
            Route::get('/live-chat/{id}', 'chat')->name('livechat.chat')->middleware('PermissionCheck:livechat_read');
            Route::post('/live-chat/store/{id}', 'store')->name('livechat.store')->middleware('PermissionCheck:livechat_create');
        });
    });

    // Admin & Super Admin live chat
    Route::prefix('admin')->middleware(['admin', 'auth', 'verified'])->group(function () {
        Route::controller(LiveChatController::class)->group(function () {
            Route::get('/live-chat', 'adminLiveChat')->name('admin.live_chat');
            Route::get('/chat-list', 'adminChatList')->name('livechat.admin_chat_list');

            Route::get('/conversation-list', 'conversationList')->name('admin.livechat.conversation_list');
            Route::get('/conversation/{id}', 'conversation')->name('admin.livechat.conversation');
        });

        Route::controller(MessageController::class)->group(function () {
            Route::get('/live-chat/{id}', 'adminChat')->name('admin_livechat.chat');
            Route::post('/live-chat/store/{id}', 'adminStore')->name('admin_livechat.store');
        });


        // Conversation
        Route::controller(ConversationController::class)->group(function () {
            Route::get('/conversation-list', 'conversationList')->name('admin.livechat.conversation_list');
            Route::get('/conversation', 'conversation')->name('admin.livechat.conversation');
        });
    });

    // student live chat
    Route::prefix('student')->middleware(['student', 'auth', 'verified'])->group(function () {
        Route::controller(LiveChatController::class)->group(function () {
            Route::get('/live-chat', 'studentLiveChat')->name('student.live_chat');
            Route::get('/chat-list', 'studentChatList')->name('livechat.student_chat_list');
        });

        Route::controller(MessageController::class)->group(function () {
            Route::get('/live-chat/{id}', 'studentChat')->name('student_livechat.chat');
            Route::post('/live-chat/store/{id}', 'studentStore')->name('student_livechat.store');
        });
    });

    // instructor live chat
    Route::prefix('instructor')->middleware(['instructor', 'auth', 'verified'])->group(function () {
        Route::controller(LiveChatController::class)->group(function () {
            Route::get('/live-chat', 'instructorLiveChat')->name('instructor.live_chat');
            Route::get('/chat-list', 'instructorChatList')->name('livechat.instructor_chat_list');
        });

        Route::controller(MessageController::class)->group(function () {
            Route::get('/live-chat/{id}', 'instructorChat')->name('instructor_livechat.chat');
            Route::post('/live-chat/store/{id}', 'instructorStore')->name('instructor_livechat.store');
        });
    });


    // Guardian live chat
    Route::prefix('guardian')->middleware(['guardian', 'auth', 'verified'])->group(function () {
        Route::controller(LiveChatController::class)->group(function () {
            Route::get('/live-chat', 'guardianLiveChat')->name('guardian.live_chat');
            Route::get('/chat-list', 'guardianChatList')->name('livechat.guardian_chat_list');
        });

        Route::controller(MessageController::class)->group(function () {
            Route::get('/live-chat/{id}', 'guardianChat')->name('guardian_livechat.chat');
            Route::post('/live-chat/store/{id}', 'guardianStore')->name('guardian_livechat.store');
        });
    });


    Route::prefix('live-chat')->middleware(['auth'])->group(function () {
        Route::controller(MessageController::class)->group(function () {
            Route::get('message-read/{id}', 'messageRead');
        });
    });

});
