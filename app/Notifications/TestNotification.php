<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestNotification extends Notification implements ShouldQueue
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
            ->subject('Тестовое уведомление') // Задаём тему письма
            ->greeting('Привет!') // Добавляем приветствие
            ->line('Это тестовое сообщение для проверки работы уведомлений.') // Основной текст
            ->action('Перейти на сайт', url('/')) // Добавляем кнопку с действием
            ->line('Спасибо за использование нашего приложения!') // Заключительный текст
            ->salutation('С уважением, команда aba-expert.ru'); // Завершаем письмо
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
