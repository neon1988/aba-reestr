<?php

use App\Http\Middleware\SEOMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            Route::middleware('api')
                ->prefix('api')
                ->as('api.')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        },
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->validateCsrfTokens(except: [
            'api/*',
            'yookassa/webhook'
        ]);

        $middleware->appendToGroup('api', [
            EnsureFrontendRequestsAreStateful::class,  // Добавлено для работы с CSRF и аутентификацией
            'throttle:api',  // Защита от DDoS атак
            SubstituteBindings::class,  // Для работы с маршрутами
        ]);

        $middleware->appendToGroup('web', [
            SEOMiddleware::class
        ]);

        $middleware->trustProxies(
            at: [
                '0.0.0.0/0'
            ],
            headers: Request::HEADER_X_FORWARDED_FOR |
            Request::HEADER_X_FORWARDED_HOST |
            Request::HEADER_X_FORWARDED_PROTO |
            Request::HEADER_X_FORWARDED_PORT |
            Request::HEADER_X_FORWARDED_PREFIX |
            Request::HEADER_X_FORWARDED_AWS_ELB |
            Request::HEADER_X_FORWARDED_TRAEFIK
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
