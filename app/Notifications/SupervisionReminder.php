<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupervisionReminder extends Notification implements ShouldQueue
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
            ->subject('🔔 Напоминание: супервизия с Еленой Сазоновой уже сегодня!')
            ->greeting('Здравствуйте!')
            ->line('Напоминаем, что уже сегодня, **20 мая в 19:00 (по Мск)** состоится супервизионная встреча с Еленой Сазоновой — сертифицированным поведенческим аналитиком (IBA), преподавателем курсов ABA от «Шаг вперёд» и супервизором Центра «Новые горизонты».')
            ->line('')
            ->line('📍 **Где:** Zoom')
            ->line('Идентификатор конференции: 815 4856 8901')
            ->line('Код доступа: 433630')
            ->action('👉 Присоединиться к встрече', 'https://us06web.zoom.us/j/81548568901?pwd=R5auChTK9hCrj9eQT9aVbB67bCaiZy.1')
            ->line('')
            ->line('🎯 **Формат:** живое обсуждение кейсов, практические рекомендации, ответы на вопросы')
            ->line('')
            ->line('📌 **Темы встречи:**')
            ->line('- Работа с ВФА: разбор методик и практических ситуаций')
            ->line('')
            ->salutation('До встречи! Команда ABA Expert');
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
