<?php

namespace App\Notifications;

use App\Services\Contracts\NotificationInterface;

class SmsNotification implements NotificationInterface
{
    public function send(string $message, string $recipient): bool
    {
        try {
            // Simulate sending SMS
            logger("SMS sent to {$recipient} with message: {$message}");
            return true;
        } catch (\Exception $e) {
            logger("Failed to send SMS to {$recipient}: " . $e->getMessage());
            return false;
        }
    }

    public function getType(): string
    {
        return 'sms';
    }
}