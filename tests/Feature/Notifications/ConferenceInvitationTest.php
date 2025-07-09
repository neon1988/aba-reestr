<?php

namespace Tests\Feature\Notifications;

use App\Models\Conference;
use App\Models\User;
use App\Notifications\ConferenceInvitationNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\Messages\MailMessage;
use Tests\TestCase;

class ConferenceInvitationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_the_mail_message_correctly()
    {
        $user = User::factory()->create();

        $conference = Conference::factory()->create();

        $notification = new ConferenceInvitationNotification($conference);

        $mailMessage = $notification->toMail($user);

        // Проверяем, что все поля письма правильные
        $this->assertInstanceOf(MailMessage::class, $mailMessage);
        $this->assertEquals('Приглашение на мероприятие: '.$conference->title, $mailMessage->subject);
        $this->assertStringContainsString('Здравствуйте, '.$user->fullName.'!', $mailMessage->greeting);
        $this->assertStringContainsString($conference->description, $mailMessage->introLines[0]);
        $this->assertStringContainsString('📅 **Дата:** '.$conference->start_at?->format('d.m.Y'), $mailMessage->introLines[1]);
        $this->assertStringContainsString('🕒 **Время:** '.$conference->start_at?->format('H:i').' (по московскому времени)', $mailMessage->introLines[2]);
        $this->assertStringContainsString('', $mailMessage->introLines[3]);
        $this->assertStringContainsString('До встречи! Команда ABA Expert', $mailMessage->salutation);
        $this->assertStringContainsString($conference->registration_url, $mailMessage->actionUrl);
        $this->assertStringContainsString($conference->url_button_text, $mailMessage->actionText);
    }
}
