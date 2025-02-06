<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountActivationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Сохранение данных уведомления (например, логин и ссылка для активации).
     *
     * @var string
     */
    protected $activationLink;

    /**
     * Создание нового экземпляра уведомления.
     *
     * @param string $activationLink
     * @return void
     */
    public function __construct($activationLink)
    {
        $this->activationLink = $activationLink;
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
            ->subject('Активируйте вашу учетную запись в АКПН')
            ->greeting('Здравствуйте, '.$notifiable->fullName.',')
            ->line('Добро пожаловать в АКПН!')
            ->line('Ваш личный кабинет на портале АКПН успешно создан! Осталось его активировать.')
            ->line('Ваш будущий логин: ' . $this->login)
            ->line('Нажмите на кнопку для перехода на портал АКПН. Вы сможете задать пароль и тем самым активировать Ваш аккаунт.')
            ->action('Активировать аккаунт', $this->activationLink) // Кнопка для активации аккаунта
            ->line('Если у Вас возникли вопросы, пишите на napishi@akpn.org')
            ->salutation('С уважением, команда АКПН');
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
