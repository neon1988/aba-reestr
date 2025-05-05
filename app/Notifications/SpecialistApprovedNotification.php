<?php

namespace App\Notifications;

use App\Models\Specialist;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SpecialistApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Specialist $specialist;

    /**
     * Create a new notification instance.
     */
    public function __construct(Specialist $specialist)
    {
        $this->specialist = $specialist;
    }

    /**
     * Get the notification's delivery channels.
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
            ->subject('Ваш профиль специалиста одобрен!')
            ->greeting('Здравствуйте, ' . $notifiable->fullName . '!')
            ->line('🎉 Ваш профиль специалиста был успешно одобрен и теперь виден пользователям!')
            ->line('Он отображается в общем списке специалистов и доступен для просмотра.')
            ->line('⚠️ Чтобы привлечь больше клиентов, обязательно дополните ваш профиль.')
            ->line('Добавьте информацию о вашем опыте, услугах, образовании и подходе к работе — это поможет выделиться среди других специалистов.')
            ->line('Хорошо оформленный профиль повышает доверие и увеличивает количество обращений.')
            ->action('Перейти к редактированию профиля', route('specialists.edit', ['specialist' => $this->specialist]));
    }
}
