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
            ->subject('🧠 Приглашение на супервизию с Еленой Сазоновой — доступно по вашему тарифу B')
            ->greeting('Здравствуйте!')
            ->line('Вы состоите в сообществе ABA-EXPERT по тарифу B и у нас для вас отличная новость!')
            ->line('Приглашаем вас на супервизионную встречу с Еленой Сазоновой — сертифицированным поведенческим аналитиком (IBA), преподавателем курсов ABA от «Шаг вперёд» и супервизором Центра «Новые горизонты».')
            ->line('🗓 **Когда:** 20 мая в 19:00')
            ->line('📍 **Где:** Zoom')
            ->line('🎯 **Формат:** живое обсуждение кейсов, практические рекомендации, ответы на ваши вопросы')
            ->line('📌 **Основные темы встречи:**')
            ->line('')
            ->line(' - Работа с ВФА: разбор методик и практических ситуаций')
            ->line(' - Установление сотрудничества и руководящего контроля')
            ->line(' - Методика PEAK: применение в практике, примеры, типичные ошибки')
            ->line('')
            ->line('Важно: Тема супервизии будет выбрана с учётом голосования участников.')
            ->line('🔔 Участие включено в ваш тариф B. Предварительная регистрация обязательна!')
            ->action('👉 Зарегистрироваться на супервизию', 'https://familyaba.getcourse.ru/page3970345#form')
            ->line('')
            ->line('Если у вас есть вопросы или вы хотите заранее прислать кейс — просто ответьте на это письмо.')
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
