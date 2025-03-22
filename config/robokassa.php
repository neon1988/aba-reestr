<?php

// config/robokassa.php
return [
    'login' => env('ROBOKASSA_LOGIN', ''),
    'password1' => env('ROBOKASSA_PASSWORD1', ''),
    'password2' => env('ROBOKASSA_PASSWORD2', ''),
    'hashType' => env('ROBOKASSA_HASH_TYPE', 'md5'),
    'is_test' => env('ROBOKASSA_IS_TEST', false), // Флаг тестового режима
];
