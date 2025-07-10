<?php

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

    // Dependency Injection Method
    public function sendNotification(Request $request)
    {
        $message = $request->input('message');
        $recipient = $request->input('recipient');
        $driver = $request->input('driver', 'email');

        try {
            $result = $this->notificationService->send($message, $recipient, $driver);
  
             return response()->json(['message' => 'Welcome notification sent!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Service Container Method
    public function sendNotificationUsingServiceContainer(Request $request)
    {
        $message = $request->input('message');
        $recipient = $request->input('recipient');
        $driver = $request->input('driver', 'email');

        try {
            $result = app(NotificationService::class)->send($message, $recipient, $driver);
            return response()->json(['message' => 'Notification sent successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Facade Method
    public function sendNotificationUsingFacade(Request $request)
    {
        $message = $request->input('message');
        $recipient = $request->input('recipient');
        $driver = $request->input('driver', 'email');

        try {
            Notification::send($message, $recipient, $driver);
            return response()->json(['message' => 'Notification sent successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}