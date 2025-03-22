<?php

namespace Tests\Feature\Payments\Robokassa;

use App\Enums\CurrencyEnum;
use App\Enums\SubscriptionLevelEnum;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatusEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Mockery;
use Tests\TestCase;

class RoboKassaBuySubscriptionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()
            ->withoutSubscription()
            ->create();
    }

    public function test_it_fails_if_subscription_type_does_not_exist()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('robokassa.buy-subscription', ['type' => 123123]));
        $response->assertStatus(404);
    }

    public function test_it_fails_if_subscription_is_free()
    {
        $this->actingAs($this->user);

        $freeSubscriptionType = SubscriptionLevelEnum::Free; // Предположим, что есть такой уровень
        $response = $this->get(route('robokassa.buy-subscription', ['type' => $freeSubscriptionType]));

        $response->assertStatus(403);
    }

    public function test_it_creates_payment_and_subscription_successfully()
    {
        $this->actingAs($this->user);

        $paidSubscriptionType = SubscriptionLevelEnum::B; // Например, ID платной подписки
        $subscriptionPrice = SubscriptionLevelEnum::fromValue(SubscriptionLevelEnum::B)->getPrice();

        // Мок сервиса оплаты, чтобы не делать реальный запрос
        $robokassaMock = Mockery::mock(\App\Services\RobokassaService::class);
        $this->app->instance(\App\Services\RobokassaService::class, $robokassaMock);

        $paymentId = Str::uuid();
        $robokassaMock->shouldReceive('createPayment')
            ->once()
            ->andReturn("https://robokassa.test/payment/{$paymentId}");

        $response = $this->get(route('robokassa.buy-subscription', ['type' => $paidSubscriptionType]))
            ->assertRedirect();

        $payment = $this->user->payments()->first();

        $this->assertNotNull($payment);
        $this->assertEquals($this->user->id, $payment->user_id);
        $this->assertEquals($subscriptionPrice, $payment->amount);
        $this->assertEquals(PaymentProvider::RoboKassa, $payment->payment_provider);
        $this->assertEquals(PaymentStatusEnum::PENDING, $payment->status);

        $purchases = $payment->purchases()->get();

        $this->assertEquals(1, $purchases->count());

        $subscription = $purchases->first()->purchasable;

        $this->assertNotNull($subscription);
        $this->assertEquals(null, $subscription->activated_at);
        $this->assertEquals($this->user->id, $subscription->user_id);
        $this->assertEquals($payment->id, $subscription->payment_id);
        $this->assertEquals(365, $subscription->days);
        $this->assertEquals(SubscriptionLevelEnum::B, $subscription->subscription_level);
        $this->assertEquals($subscriptionPrice, $subscription->amount);
        $this->assertEquals(CurrencyEnum::RUB, $subscription->currency);

        // Проверяем, что был редирект на страницу оплаты
        $response->assertRedirect("https://robokassa.test/payment/{$paymentId}");
    }
}
