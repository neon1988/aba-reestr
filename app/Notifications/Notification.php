<?php

namespace App\Notifications;

use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Notifications\Notification as BaseNotification;

class Notification extends BaseNotification
{
    /**
     * Get the middleware the notification job should pass through.
     *
     * @return array<int, object>
     */
    public function middleware(object $notifiable, string $channel): array
    {
        return match ($channel) {
            'mail' => [new RateLimited('smtp.bz')],
            default => [],
        };
    }

    /**
     * Determine which connections should be used for each notification channel.
     *
     * @return array<string, string>
     */
    public function viaConnections(): array
    {
        return [
            'mail' => 'database',
            'database' => 'sync',
        ];
    }
}
