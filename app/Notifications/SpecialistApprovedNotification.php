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
            ->line('Мы рады сообщить, что ваш профиль специалиста был успешно одобрен.')
            ->action('Перейти на страницу', route('specialists.show', ['specialist' => $this->specialist]))
            ->line('Теперь ваш профиль доступен пользователям, и отображается в списке специалистов.');
    }
}
