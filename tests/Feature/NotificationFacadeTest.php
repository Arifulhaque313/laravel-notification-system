<?php
namespace Tests\Feature;

use App\Facades\Notification;
use Tests\TestCase;

class NotificationFacadeTest extends TestCase
{
    public function test_facade_can_send_notification()
    {
        // Mock the facade
        Notification::shouldReceive('send')
            ->once()
            ->with('Test message', 'test@example.com')
            ->andReturn(true);

        $result = Notification::send('Test message', 'test@example.com');
        
        $this->assertTrue($result);
    }
}