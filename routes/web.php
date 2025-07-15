<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NotificationController::class, 'index'])->name('notification.demo');

// API routes for sending notifications
Route::post('/send-notification-di', [NotificationController::class, 'sendNotification'])->name('notification.send.di');
Route::post('/send-notification-container', [NotificationController::class, 'sendNotificationUsingServiceContainer'])->name('notification.send.container');
Route::post('/send-notification-facade', [NotificationController::class, 'sendNotificationUsingFacade'])->name('notification.send.facade');
Route::get('/notification-drivers', [NotificationController::class, 'getDrivers'])->name('notification.drivers');