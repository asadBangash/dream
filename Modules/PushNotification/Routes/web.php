<?php

use \Modules\PushNotification\Http\Controllers\PushNotificationController;
use \Illuminate\Support\Facades\Route;

Route::controller(PushNotificationController::class)->group(function () {

    Route::post('/store-fcm-token', 'storeFcmToken');
    Route::post('/subscribe-to-topic', 'subscribeToTopic');

    Route::get('/send-notification', 'sendTestNotification');
    Route::get('/send-topic-notification', 'notification');
    Route::get('/service-worker.js', 'generateServiceWorker')->name('service.worker');
});
