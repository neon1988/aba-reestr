<?php

namespace App\Notifications;

use App\Enums\SubscriptionLevelEnum;
use App\Models\PurchasedSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionActivatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Сохранение данных уведомления (если нужно передать что-то конкретное, например, ссылку).
     *
     */
    protected PurchasedSubscription $subscription;

    /**
     * Создание нового экземпляра уведомления.
     *
     * @param PurchasedSubscription $subscription
     * @return void
     */
    public function __construct(PurchasedSubscription $subscription)
    {
        $this->subscription = $subscription;
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
        $mail = (new MailMessage)
            ->subject('Подписка "'.SubscriptionLevelEnum::getDescription($this->subscription->subscription_level).'" активирована')
            ->greeting('Здравствуйте, '.$notifiable->fullName.',')
            ->line('Ваша подписка "'.SubscriptionLevelEnum::getDescription($this->subscription->subscription_level).'" активирована');

        if ($this->subscription->subscription_level == SubscriptionLevelEnum::Specialists) {
            $mail = $mail->action('Зарегистрировать страницу специалиста', route('join.specialist'));
        }
        elseif ($this->subscription->subscription_level == SubscriptionLevelEnum::Centers) {
            $mail = $mail->action('Зарегистрировать страницу центра', route('join.center'));
        }
        elseif ($this->subscription->subscription_level == SubscriptionLevelEnum::ParentsAndRelated) {
            $mail = $mail->action('Перейти на сайт', route('home'));
        }

        return $mail;
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
