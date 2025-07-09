<?php

namespace Tests\Feature\Commands;

use App\Console\Commands\ConferenceSendInvitation;
use App\Enums\SubscriptionLevelEnum;
use App\Models\Conference;
use App\Models\User;
use App\Notifications\ConferenceInvitationNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ConferenceSendInvitationCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_fails_if_conference_is_ended()
    {
        $conference = Conference::factory()->create([
            'end_at' => now()->subDay(),
            'available_for_subscriptions' => [SubscriptionLevelEnum::A]
        ]);

        $this->artisan('conference:send-invitations', ['id' => $conference->id])
            ->expectsOutput('The conference is ended')
            ->assertExitCode(1);
    }

    public function test_command_fails_if_not_should_notify()
    {
        $conference = Conference::factory()->create([
            'end_at' => now()->addDay(),
            'last_notified_at' => now()->subMinutes(3),
            'available_for_subscriptions' => [SubscriptionLevelEnum::A]
        ]);

        $this->artisan('conference:send-invitations', ['id' => $conference->id])
            ->expectsOutput('The notifications were sent very recently.')
            ->assertExitCode(1);
    }

    public function test_command_fails_if_no_subscription_levels()
    {
        $conference = Conference::factory()->create([
            'end_at' => now()->addDay(),
            'last_notified_at' => now()->subHour(),
            'available_for_subscriptions' => [],
        ]);

        $this->artisan('conference:send-invitations', ['id' => $conference->id])
            ->expectsOutput('The conference is not available for subscriptions.')
            ->assertExitCode(1);
    }

    public function test_command_sends_notifications_to_eligible_users()
    {
        Notification::fake();

        $conference = Conference::factory()->create([
            'start_at' => now()->addDay(),
            'end_at' => now()->addDays(2),
            'last_notified_at' => now()->subHour(),
            'available_for_subscriptions' => [SubscriptionLevelEnum::A]
        ]);

        User::truncate();

        $eligibleUser = User::factory()->create([
            'subscription_level' => SubscriptionLevelEnum::A,
            'subscription_ends_at' => now()->addMonth(),
            'email' => 'test@example.com',
        ]);

        $this->assertTrue($eligibleUser->isSubscriptionActive());

        $ineligibleUser = User::factory()->create([
            'subscription_level' => SubscriptionLevelEnum::A,
            'subscription_ends_at' => now()->subDay(), // expired
            'email' => 'nope@example.com',
        ]);

        $ineligibleUser2 = User::factory()->create([
            'subscription_level' => SubscriptionLevelEnum::B,
            'subscription_ends_at' => now()->addMonth(),
            'email' => 'test2@example.com',
        ]);

        $this->artisan('conference:send-invitations', ['id' => $conference->id])
            ->assertExitCode(0)
            ->doesntExpectOutput('Отправлено 0.')
            ->doesntExpectOutput('Отправлено 2.')
            ->doesntExpectOutput('Отправлено 3.')
            ->doesntExpectOutput('The conference is ended')
            ->doesntExpectOutput('The notifications were sent very recently.')
            ->doesntExpectOutput('The conference is not available for subscriptions.')
            ->expectsOutput('Отправлено 1.');

        Notification::assertSentTo($eligibleUser, ConferenceInvitationNotification::class);
        Notification::assertNotSentTo($ineligibleUser, ConferenceInvitationNotification::class);
        Notification::assertNotSentTo($ineligibleUser2, ConferenceInvitationNotification::class);

        $this->assertNotNull($conference->fresh()->last_notified_at);
    }
}
