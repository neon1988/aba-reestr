<?php

use Illuminate\Http\Request;

return [
    'proxies' => '*', // Доверять всем прокси (или укажите конкретный IP)
    'headers' => Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_PREFIX |
        Request::HEADER_X_FORWARDED_AWS_ELB |
        Request::HEADER_X_FORWARDED_TRAEFIK
];
