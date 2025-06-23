<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
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
            ->subject('Приглашение на супервизионную встречу с Ольгой Князевой — уже 24 июня!')
            ->greeting('Здравствуйте!')
            ->line('Приглашаем вас на открытую супервизионную встречу с Ольгой Князевой — сертифицированным поведенческим аналитиком (BCaBA, IBA), основателем Центра «Новые горизонты».')
            ->line('📅 **Дата:** 24 июня 2025 г.')
            ->line('🕗 **Время:** 20:15–21:15 (МСК)')
            ->line('🎯 **Формат:** обсуждение кейсов, сессия "вопрос-ответ", практические рекомендации')
            ->line('💬 **Тема встречи:** Пищевая избирательность у детей с РАС')
            ->line('✅ **Для кого:** участников тарифа В')
            ->line('📍 **Платформа:** Zoom')
            ->action('👉 Перейти по ссылке для подключения', 'https://us06web.zoom.us/j/82919109477?pwd=7CSpvHBJsCGoWOqYa224mfA8AMdkZX.1')
            ->line('🔑 **Идентификатор конференции:** 829 1910 9477')
            ->line('🔒 **Код доступа:** 637390')
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
