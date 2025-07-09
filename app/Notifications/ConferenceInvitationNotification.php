<?php

namespace App\Notifications;

use App\Models\Conference;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Str;

class ConferenceInvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Conference $conference)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $startDate = $this->conference->start_at?->format('d.m.Y');
        $startTime = $this->conference->start_at?->format('H:i');

        $message = (new MailMessage)
            ->subject("Приглашение на мероприятие: {$this->conference->title}")
            ->greeting('Здравствуйте, '.$notifiable->fullName.'!');

        // Если description многострочный — разбиваем на строки
        if (Str::contains($this->conference->description, "\n")) {
            foreach (explode("\n", $this->conference->description) as $line) {
                $message->line(trim($line));
            }
        } else {
            $message->line($this->conference->description);
        }

        $message
            ->line("📅 **Дата:** {$startDate}")
            ->line("🕒 **Время:** {$startTime} (по московскому времени)");

        if (!empty($this->conference->registration_url)) {
            $message->line('')
                ->action('Перейти', $this->conference->registration_url);
        }

        $message->line('')
            ->line('Если у вас есть вопросы — напишите нам по [контактам]('.route('contacts').')')
            ->salutation('До встречи! Команда ABA Expert');

        return $message;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'conference_id' => $this->conference->id,
            'title' => $this->conference->title,
        ];
    }
}
