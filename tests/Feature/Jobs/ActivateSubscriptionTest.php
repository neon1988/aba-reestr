<?php

namespace Tests\Feature\Jobs;

use App\Enums\PaymentStatusEnum;
use App\Enums\SubscriptionLevelEnum;
use App\Jobs\ActivateSubscription;
use App\Models\Payment;
use App\Models\PurchasedSubscription;
use App\Models\User;
use App\Notifications\SubscriptionActivatedNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ActivateSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_subscription_is_activated_if_not_already_activated()
    {
        Carbon::setTestNow('2025-02-06 12:00:00');

        // Создаем пользователя и подписку
        $user = User::factory()
            ->create([
                'subscription_level' => SubscriptionLevelEnum::getRandomValue(),
                'subscription_ends_at' => null
            ]);

        $payment = Payment::factory()->create([
            'user_id' => $user->id,
            'status' => PaymentStatusEnum::fromValue(PaymentStatusEnum::SUCCEEDED)->key,
        ]);

        $days = 365;

        $subscription = PurchasedSubscription::factory()
            ->for($payment)
            ->create([
                'subscription_level' => SubscriptionLevelEnum::Specialists,
                'user_id' => $user->id,
                'days' => $days,
                'activated_at' => null,
            ]);

        // Мокаем уведомления, чтобы не отправлять их на email
        Notification::fake();

        // Запускаем задачу
        $job = new ActivateSubscription($subscription);
        $job->handle();

        // Проверяем, что подписка была активирована
        $subscription->refresh();
        $user->refresh();

        $this->assertNotNull($subscription->activated_at);
        $this->assertEquals(SubscriptionLevelEnum::Specialists, $user->subscription_level);
        $this->assertEquals(Carbon::createFromTimeString('2026-02-06 12:00:00.000000'), $user->subscription_ends_at);

        Notification::assertSentTo($user, SubscriptionActivatedNotification::class);
    }

    public function test_append_subscription_time()
    {
        Carbon::setTestNow('2020-02-06 12:00:00');

        // Создаем пользователя и подписку
        $user = User::factory()
            ->create([
                'subscription_level' => SubscriptionLevelEnum::Specialists,
                'subscription_ends_at' => '2026-02-06 12:00:00'
            ]);

        $payment = Payment::factory()->create([
            'user_id' => $user->id,
            'status' => PaymentStatusEnum::fromValue(PaymentStatusEnum::SUCCEEDED)->key,
        ]);

        $days = 365;

        $subscription = PurchasedSubscription::factory()
            ->for($payment)
            ->create([
                'subscription_level' => SubscriptionLevelEnum::Specialists,
                'user_id' => $user->id,
                'days' => $days,
                'activated_at' => null,
            ]);

        // Мокаем уведомления, чтобы не отправлять их на email
        Notification::fake();

        // Запускаем задачу
        $job = new ActivateSubscription($subscription);
        $job->handle();

        // Проверяем, что подписка была активирована
        $subscription->refresh();
        $user->refresh();

        $this->assertNotNull($subscription->activated_at);
        $this->assertEquals(SubscriptionLevelEnum::Specialists, $user->subscription_level);
        $this->assertEquals(Carbon::createFromTimeString('2027-02-06 12:00:00.000000'), $user->subscription_ends_at);

        Notification::assertSentTo($user, SubscriptionActivatedNotification::class);
    }
}
