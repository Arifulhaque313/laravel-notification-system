<?php
// tests/Unit/NotificationServiceTest.php

namespace Tests\Unit;

use App\Notifications\EmailNotification;
use App\Services\NotificationService;
use PHPUnit\Framework\TestCase;

class NotificationServiceTest extends TestCase
{
    public function test_can_send_notification()
    {
        $emailDriver = new EmailNotification();
        $service = new NotificationService(['email' => $emailDriver]);
        
        $result = $service->send('Test message', 'test@example.com');
        
        $this->assertTrue($result);
    }
}