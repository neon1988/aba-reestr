<?php

namespace Tests\Feature\Notifications;

use App\Models\Specialist;
use App\Models\User;
use App\Notifications\SpecialistApprovedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\Messages\MailMessage;
use Tests\TestCase;

class SpecialistApprovedNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_uses_the_mail_channel()
    {
        $specialist = Specialist::factory()->create(); // Создание специалиста

        // Мокаем уведомление и проверяем каналы
        $notification = new SpecialistApprovedNotification($specialist);

        $this->assertEquals(['mail'], $notification->via($specialist));
    }

    public function test_it_creates_the_mail_message_correctly()
    {
        $specialist = Specialist::factory()->create(); // Создание специалиста
        $user = User::factory()->create(); // Создание специалиста

        $notification = new SpecialistApprovedNotification($specialist);

        $mailMessage = $notification->toMail($user);

        // Проверяем, что все поля письма правильные
        $this->assertInstanceOf(MailMessage::class, $mailMessage);
        $this->assertEquals('Ваш профиль специалиста одобрен!', $mailMessage->subject);
        $this->assertStringContainsString('Здравствуйте, '.$user->fullName.'!', $mailMessage->greeting);
        $this->assertStringContainsString('Мы рады сообщить, что ваш профиль специалиста был успешно одобрен.', $mailMessage->introLines[0]);
        $this->assertStringContainsString(route('specialists.show', ['specialist' => $specialist]), $mailMessage->actionUrl);
    }
}
