<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MembershipConfirmationNotification extends Notification
{
    use Queueable;

    /**
     * Сохранение данных уведомления (если нужно передать что-то конкретное, например, ссылку).
     *
     * @var string
     */
    protected $paymentLink;

    /**
     * Создание нового экземпляра уведомления.
     *
     * @param string $paymentLink
     * @return void
     */
    public function __construct($paymentLink)
    {
        $this->paymentLink = $paymentLink;
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
            ->subject('Вступление в Ассоциацию АКПН')
            ->greeting('Здравствуйте, '.$notifiable->fullName.',')
            ->line('Мы очень рады, что Вы решили стать членом нашей Ассоциации.')
            ->line('Мы проверили ваши документы и теперь для завершения процедуры вступления необходимо сделать два шага:')
            ->line('1. Оплатить по ссылке вступительный взнос. (Высылать нам подтверждение не надо). ВАЖНО: Доступ в личный кабинет открывается, только после того, как деньги поступят на счет и это требует некоторого времени (обычно несколько часов). После этого Вам придет письмо, что ваш личный кабинет создан.')
            ->line('2. После того, как станет доступным личный кабинет, загрузить в него ваше фото и заполнить информацию о себе.')
            ->action('Ссылка на оплату', $this->paymentLink) // Добавляем ссылку для оплаты
            ->line('Если у Вас возникли вопросы, пишите на napishi@akpn.org')
            ->line('С уважением, команда АКПН');
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
