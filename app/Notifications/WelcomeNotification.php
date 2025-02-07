<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Сохранение данных уведомления (например, логин и ссылка для перехода в кабинет).
     *
     * @var string
     */
    protected $user;
    protected $accountLink;

    /**
     * Создание нового экземпляра уведомления.
     *
     * @param string $accountLink
     * @return void
     */
    public function __construct($accountLink)
    {
        $this->accountLink = $accountLink;
    }

    /**
     * Получить каналы уведомлений, которые должны быть использованы.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail']; // Уведомление будет отправлено на email
    }

    /**
     * Получить сообщение, которое будет отправлено.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Добро пожаловать!')
            ->greeting('Здравствуйте, ' . $notifiable->fullName . '!')
            ->line('Ваш личный кабинет на портале ABA-Expert успешно создан!')
            ->action('Перейти в аккаунт', $this->accountLink) // Кнопка для перехода в кабинет
            ->salutation('С уважением, команда ABA-Expert');
    }

    /**
     * Получить массив представлений для отправки уведомления через другие каналы (например, база данных, SMS).
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            // Дополнительные данные для уведомления, если необходимо
        ];
    }
}
