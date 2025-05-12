<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PromocodeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Промокод после оплаты тарифа')
            ->greeting('Здравствуйте!')
            ->line('Благодарим вас за покупку тарифа и добро пожаловать в ABA-EXPERT — сообщество специалистов в области прикладного анализа поведения.')
            ->line('Мы рады, что вы с нами, и уверены, что вместе мы сможем сделать помощь детям с особенностями развития ещё более профессиональной, системной и доступной.')
            ->line('🎁 В знак благодарности дарим вам промокод на 1000 рублей на любые материалы в нашем партнёрском проекте [aba-family.ru](https://aba-family.ru/).')
            ->line('**Промокод: 1000**')
            ->line('(вводите его на этапе оплаты)')
            ->line('Если возникнут вопросы или нужна будет помощь — пишите, всегда на связи.')
            ->salutation('С уважением, ABA-EXPERT');
    }
}
