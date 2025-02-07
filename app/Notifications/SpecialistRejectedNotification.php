<?php

namespace App\Notifications;

use App\Models\Specialist;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SpecialistRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Specialist $specialist;

    /**
     * Create a new notification instance.
     */
    public function __construct(Specialist $specialist)
    {
        $this->specialist = $specialist;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Ваш профиль специалиста отклонен')
            ->greeting('Здравствуйте, ' . $notifiable->fullName . '!')
            ->line('К сожалению, ваш профиль специалиста был отклонен.')
            ->line('Причиной может быть некорректное заполнение информации или несоответствие требованиям платформы.')
            ->line('Если у вас есть вопросы или вы хотите внести изменения в профиль, свяжитесь с нами.')
            ->action('Связаться с поддержкой', route('contacts'));
    }
}
