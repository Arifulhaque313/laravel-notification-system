<?php 

namespace App\Notifications;

use App\Services\Contracts\NotificationInterface;

class SlackNotification implements NotificationInterface
{
    public function send(string $message, string $recipient): bool
    {
        try {
            // Simulate sending Slack message
            logger("Slack message sent to {$recipient} with message: {$message}");
            return true;
        } catch (\Exception $e) {
            logger("Failed to send Slack message to {$recipient}: " . $e->getMessage());
            return false;
        }
    }

    public function getType(): string
    {
        return 'slack';
    }
}