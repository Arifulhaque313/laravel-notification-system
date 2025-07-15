<?php
// app/Http/Controllers/NotificationController.php

namespace App\Http\Controllers;

use App\Facades\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    // Show the demo page
    public function index()
    {
        return view('welcome');
    }

    // Dependency Injection Method
    public function sendNotification(Request $request)
    {
        $message = $request->input('message');
        $recipient = $request->input('recipient');
        $driver = $request->input('driver');

        try {
            $result = $this->notificationService->send($message, $recipient, $driver);
            return response()->json([
                'success' => true,
                'message' => 'Notification sent successfully using Dependency Injection!',
                'method' => 'Dependency Injection',
                'driver' => $driver,
                'notification_message' => $message,
                'recipient' => $recipient
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Service Container Method
    public function sendNotificationUsingServiceContainer(Request $request)
    {
        $message = $request->input('message');
        $recipient = $request->input('recipient');
        $driver = $request->input('driver');

        try {
            $result = app(NotificationService::class)->send($message, $recipient, $driver);
            return response()->json([
                'success' => true,
                'message' => 'Notification sent successfully using Service Container!',
                'method' => 'Service Container',
                'driver' => $driver,
                'notification_message' => $message,
                'recipient' => $recipient
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Facade Method
    public function sendNotificationUsingFacade(Request $request)
    {
        $message = $request->input('message');
        $recipient = $request->input('recipient');
        $driver = $request->input('driver');

        try {
            Notification::send($message, $recipient, $driver);
            return response()->json([
                'success' => true,
                'message' => 'Notification sent successfully using Facade!',
                'method' => 'Facade',
                'driver' => $driver,
                'notification_message' => $message,
                'recipient' => $recipient
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Get available drivers
    public function getDrivers()
    {
        try {
            $drivers = $this->notificationService->getAvailableDrivers();
            return response()->json([
                'success' => true,
                'drivers' => $drivers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}