<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'specialists*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['http://localhost', 'http://localhost:9001', 'http://localhost:9000', 'https://642a-94-159-97-254.ngrok-free.app'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,
];
