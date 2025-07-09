<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SupervisionInvitation extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
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
            ->subject('Приглашение на групповую супервизию с Круогла Еленой — 10 июля')
            ->greeting('Дорогие коллеги!')
            ->line('Приглашаем вас на групповую супервизию с Круогла Еленой — учителем-логопедом, дефектологом, терапистом ESDM, специалистом PECS, автором методических пособий и соучредителем онлайн-проекта Мастерская лого.')
            ->line('Это отличная возможность разобрать сложные случаи из практики, получить профессиональную поддержку и ценные рекомендации от эксперта.')
            ->line('📅 **Дата:** 10 июля')
            ->line('🕕 **Время:** 18:00 (по московскому времени)')
            ->line('📍 **Формат:** Zoom')
            ->action('👉 Перейти по ссылке для подключения', 'https://us06web.zoom.us/j/88517526771?pwd=oQKZjzGYbKZApr00rIR3ThoZFwa42S.1')
            ->line('🔑 **Идентификатор конференции:** 885 1752 6771')
            ->line('🔒 **Код доступа:** 695021')
            ->line('')
            ->line('Если у вас есть вопросы или вы хотите заранее прислать кейс — напишите нам по [контактам]('.route('contacts').')')
            ->salutation('До встречи на супервизии! Команда ABA Expert');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
