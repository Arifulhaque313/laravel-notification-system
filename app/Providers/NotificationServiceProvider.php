<?php

namespace App\Providers;

use App\Notifications\EmailNotification;
use App\Notifications\SlackNotification;
use App\Notifications\SmsNotification;
use App\Services\NotificationService;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('notification.email', function ($app) {
            return new EmailNotification();
        });

        $this->app->bind('notification.sms', function ($app) {
            return new SmsNotification();
        });

        $this->app->bind('notification.slack', function ($app) {
            return new SlackNotification();
        });

        $this->app->singleton(NotificationService::class, function ($app) {
            $drivers = [
                'email' => $app->make('notification.email'),
                'sms' => $app->make('notification.sms'),
                'slack' => $app->make('notification.slack'),
            ];

            return new NotificationService($drivers);
        });

        // Create an alias for easier access
        $this->app->alias(NotificationService::class, 'notification');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $service = $this->app->make(NotificationService::class);
        $service->setDefaultDriver(config('services.notification.default', 'email'));
    }

    /**
     * Get the services provided by the provider
     */
    public function provides(): array
    {
        return [
            NotificationService::class,
            'notification',
            'notification.email',
            'notification.sms',
            'notification.slack',
        ];
    }
}
