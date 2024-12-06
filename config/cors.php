<?php

use Litlife\Url\Url;

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'], // Разрешить все HTTP-методы

    'allowed_origins' => [
        env('APP_URL', 'http://localhost'),
        '*.'.Url::fromString(env('APP_URL', 'http://localhost'))->getHost(),
        'http://192.168.99.2:*'
    ],

    'allowed_origins_patterns' => [], // Если нужно использовать шаблоны, оставьте здесь

    'allowed_headers' => ['*'], // Разрешить все заголовки

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false, // Оставьте false, если не используете cookies/sessions
];
