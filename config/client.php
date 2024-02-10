<?php

return [
    'notifications' => [
        'register' => env('CLIENT_NOTIFY_REG_CHANNEL', 'log'),
        'hot' => env('CLIENT_NOTIFY_HOT_CHANNEL', 'log'),
        'review' => env('CLIENT_NOTIFY_REVIEW_CHANNEL', 'log'),

        'channels' => [
            'log' => App\Channels\LogChannel::class,
            'sms' => App\Channels\SmsChannel::class,
            'whatsap' => App\Channels\WhatsappChannel::class,
            'mail' => 'mail'
        ],
    ]
];
