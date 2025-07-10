<?php
return [
    'default' => env('NOTIFICATION_DRIVER', 'email'),
    
    'drivers' => [
        'email' => [
            'enabled' => true,
            'from' => env('MAIL_FROM_ADDRESS'),
        ],
        'sms' => [
            'enabled' => env('SMS_ENABLED', false),
            'provider' => env('SMS_PROVIDER', 'twilio'),
        ],
        'slack' => [
            'enabled' => env('SLACK_ENABLED', false),
            'webhook' => env('SLACK_WEBHOOK_URL'),
        ],
    ],
];