<?php

namespace App\Notifications;

use App\Models\Specialist;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SpecialistPendingReviewNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Specialist $specialist;

    /**
     * Создает новый экземпляр уведомления.
     */
    public function __construct(Specialist $specialist)
    {
        $this->specialist = $specialist;
    }

    /**
     * Определяет каналы доставки уведомления.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Формирует сообщение для отправки по почте.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Новый специалист ожидает проверки')
            ->greeting('Здравствуйте, ' . $notifiable->fullName . '!')
            ->line('Появился новый специалист, и его профиль ожидает проверки.')
            ->line('Пожалуйста, ознакомьтесь с данными специалиста и примите решение о его статусе.')
            ->action('Проверить профиль', "".config('app.manage_url')."/#/specialists/{$this->specialist->id}/edit")
            ->line('Спасибо за оперативную работу!');
    }
}
