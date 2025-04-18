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
        $subscriptionLevel = SubscriptionLevelEnum::getDescription($this->subscription->subscription_level);

        $mail = (new MailMessage)
            ->subject('Подписка "' . $subscriptionLevel . '" активирована')
            ->greeting('Здравствуйте, ' . $notifiable->fullName . ',');

        if ($this->subscription->subscription_level == SubscriptionLevelEnum::B) {
            $mail->line('Вы успешно приобрели тариф B!')
                ->line('Теперь у вас открыт доступ к размещению информации о себе в нашем реестре специалистов и организаций, работающих с детьми с особенностями развития.')
                ->line('**Ваши дальнейшие шаги:**')
                ->line('1) Переходите на сайт и добавьте документы на проверку')
                ->line('2) После проверки документов вы сможете отредактировать свою карточку специалиста')
                ->line('3) Отредактируйте карточку специалиста, укажите ту информацию, которую вы хотели бы видеть на своей страничке')
                ->line('**Размещение в реестре — это:**')
                ->line('– ваша визитка, доступная родителям и коллегам по всей стране;')
                ->line('– возможность быть замеченным при поиске специалистов по регионам;')
                ->line('– участие в системе рекомендаций от нашего проекта.')
                ->line('Если возникнут вопросы — пишите, поможем!')
                ->action('Зарегистрировать страницу специалиста', route('join.specialist'));
        } elseif ($this->subscription->subscription_level == SubscriptionLevelEnum::C) {
            $mail->line('Вы успешно приобрели тариф C!')
                ->line('Теперь вы можете разместить информацию о вашем центре в реестре ABA-EXPERT — крупнейшем сообществе специалистов и организаций, работающих с детьми с особенностями развития.')
                ->line('**Ваши дальнейшие шаги:**')
                ->line('1) Перейдите на сайт и добавьте документы центра для верификации')
                ->line('2) После проверки документов вы сможете заполнить страницу вашего центра')
                ->line('3) Укажите ключевую информацию, которая поможет родителям и коллегам найти ваш центр')
                ->line('**Размещение центра в реестре — это:**')
                ->line('– дополнительный канал привлечения клиентов;')
                ->line('– участие в профессиональном сообществе и доступ к закрытым мероприятиям;')
                ->line('– повышение доверия через верификацию и рекомендации от проекта.')
                ->line('Если возникнут вопросы — напишите нам, мы обязательно поможем!')
                ->action('Зарегистрировать страницу центра', route('join.center'));
        } elseif ($this->subscription->subscription_level == SubscriptionLevelEnum::A) {
            $mail->line('Здравствуйте!')
                ->line('Благодарим вас за покупку тарифа и добро пожаловать в ABA-EXPERT — российское сообщество специалистов в области прикладного анализа поведения.')
                ->line('Мы рады, что вы с нами, и уверены, что вместе мы сможем сделать помощь детям с особенностями развития ещё более профессиональной, системной и доступной.')
                ->line('🎁 В знак благодарности дарим вам промокод на 1000 рублей на любые материалы в нашем партнёрском проекте [aba-family.ru](https://aba-family.ru/).')
                ->line('**Промокод:** 1000 (вводите его на этапе оплаты)')
                ->line('Если возникнут вопросы или нужна будет помощь — пишите, всегда на связи.')
                ->action('Перейти на сайт', route('home'));
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
