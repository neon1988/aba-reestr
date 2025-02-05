<?php

namespace Tests\Feature\Payments\YooKassa;

use App\Enums\CurrencyEnum;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatusEnum;
use App\Enums\SubscriptionLevelEnum;
use App\Models\User;
use App\Services\YooKassaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class YooKassaBuySubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_buy_subscription_success()
    {
        $user = User::factory()->create();

        $subscriptionType = SubscriptionLevelEnum::Specialists;

        $price = SubscriptionLevelEnum::coerce($subscriptionType)->getPrice();

        $mockService = Mockery::mock(YooKassaService::class);
        $mockService->shouldReceive('getNewIdempotenceKey')->andReturn(42);
        $mockService->shouldReceive('createPayment')
            ->once()
            ->withArgs(function ($amount, $returnUrl, $description, $metadata) use ($user) {
                // Проверяем сумму платежа
                $this->assertEquals(3500, $amount); // Например, 100 рублей
                $this->assertEquals(route('yookassa.payment.return', ['uuid' => 42]), $returnUrl);
                $this->assertEquals('Оплата подписки "Специалисты"', $description);

                // Проверяем метаданные
                $this->assertArrayHasKey('user_id', $metadata);
                $this->assertEquals($user->id, $metadata['user_id']);
                $this->assertArrayHasKey('subscription_type', $metadata);

                return true;
            })
            ->andReturn(new class {
                public function getId()
                {
                    return 'test_yookassa_id';
                }

                public function getStatus()
                {
                    return 'pending';
                }

                public function getPaymentMethod()
                {
                    return 'card';
                }

                public function toArray()
                {
                    return ['mocked' => 'data'];
                }

                public function getConfirmation()
                {
                    return new class {
                        public function getConfirmationUrl()
                        {
                            return 'https://fake-confirmation-url.com';
                        }
                    };
                }
            });


        $this->app->instance(YooKassaService::class, $mockService);

        $response = $this->actingAs($user)
            ->get(route('yookassa.buy-subscription', ['type' => $subscriptionType]))
            ->assertRedirect('https://fake-confirmation-url.com')
            ->assertSessionHas('payments.' . 42 . '.yookassa_id', 'test_yookassa_id');

        $payment = $user->payments()->first();

        $response->assertSessionHas('payments.' . 42 . '.id', $payment->id);

        $this->assertNotNull($payment);
        $this->assertEquals("test_yookassa_id", $payment->payment_id);
        $this->assertEquals(PaymentProvider::YooKassa, $payment->payment_provider);
        $this->assertEquals(3500, $payment->amount);
        $this->assertEquals(CurrencyEnum::RUB, $payment->currency);
        $this->assertEquals(PaymentStatusEnum::PENDING, $payment->status);
        $this->assertEquals(['mocked' => 'data'], $payment->meta);
    }

    public function test_buy_subscription_fails_for_free()
    {
        $user = User::factory()->create();

        $subscriptionType = SubscriptionLevelEnum::Free; // Бесплатная подписка

        $response = $this->actingAs($user)
            ->get(route('yookassa.buy-subscription', ['type' => $subscriptionType]));

        $response->assertStatus(403);
    }

    public function test_buy_subscription_fails_for_invalid_type()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('yookassa.buy-subscription', ['type' => 999])); // Несуществующая подписка

        $response->assertStatus(404);
    }

    public function test_buy_subscription_fails_when_payment_creation_fails()
    {
        $user = User::factory()->create();

        $subscriptionType = SubscriptionLevelEnum::Specialists;

        $mockService = Mockery::mock(YooKassaService::class);
        $mockService->shouldReceive('createPayment')->andReturn(null); // Эмулируем ошибку
        $mockService->shouldReceive('getNewIdempotenceKey')->andReturn(42);
        $this->app->instance(YooKassaService::class, $mockService);

        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Ошибка создания платежа');

        $this->actingAs($user)
            ->get(route('yookassa.buy-subscription', ['type' => $subscriptionType]));
    }
}

