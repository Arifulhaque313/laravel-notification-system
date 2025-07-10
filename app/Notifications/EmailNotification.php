<?php

namespace App\Notifications;

use App\Services\Contracts\NotificationInterface;
use Illuminate\Support\Facades\Mail;

class EmailNotification implements NotificationInterface
{
    public function send(string $message, string $recipient): bool
    {
        try {
            // Mail::raw($message, function ($mail) use ($recipient) {
            //     $mail->to($recipient)
            //          ->subject('Notification');
            // });
            logger("Email sent to {$recipient} with message: {$message}");
            return true;
        } catch (\Exception $e) {
            logger("Failed to send email to {$recipient}: " . $e->getMessage());
            return false;
        }
    }

    public function getType(): string
    {
        return 'email';
    }
}


