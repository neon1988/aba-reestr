<?php

namespace Tests\Feature\Payments\YooKassa;

use App\Enums\PaymentProvider;
use App\Enums\PaymentStatusEnum;
use App\Enums\SubscriptionLevelEnum;
use App\Models\Payment;
use App\Models\User;
use App\Services\YooKassaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class YooKassaPaymentShowTest extends TestCase
{
    use RefreshDatabase;

    protected YooKassaService $yooKassaMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->yooKassaMock = Mockery::mock(YooKassaService::class);
        $this->app->instance(YooKassaService::class, $this->yooKassaMock);
    }

    public function test_payment_show_displays_success_when_payment_succeeded()
    {
        $yookassaId = uniqid();

        $subscription = SubscriptionLevelEnum::B;

        $mockResponse = Mockery::mock();
        $mockResponse->shouldReceive('getId')->andReturn($yookassaId);
        $mockResponse->shouldReceive('getStatus')->andReturn('succeeded');

        $mockPaymentMethod = Mockery::mock();
        $mockPaymentMethod->shouldReceive('getType')->andReturn('bank_card');

        $mockResponse->shouldReceive('getPaymentMethod')->andReturn($mockPaymentMethod);
        $mockResponse->shouldReceive('toArray')
            ->andReturn([
                'status' => 'succeeded',
                'metadata' => [
                    'order_id' => 'ORDER_123',
                    'subscription_type' => SubscriptionLevelEnum::fromValue($subscription)->key
                ],
            ]);

        $this->yooKassaMock->shouldReceive('getPaymentInfo')
            ->with(Mockery::on(fn($id) => (string) $id === $yookassaId))
            ->andReturn($mockResponse);

        $user = User::factory()
            ->create([
                'subscription_level' => SubscriptionLevelEnum::getRandomValue(),
                'subscription_ends_at' => null
            ]);

        $payment = Payment::factory()
            ->for($user)
            ->create([
                'payment_provider' => PaymentProvider::YooKassa,
                'payment_id' => $yookassaId
            ]);

        $this->assertNull($user->purchasedSubscriptions()->first());

        // Выполняем запрос
        $response = $this->actingAs($user)
            ->get(route('payments.show', ['payment' => $payment->id]))
            ->assertOk()
            ->assertViewIs('payments.success');

        $purchasedSubscription = $user->purchasedSubscriptions()->first();
        $payment = $user->payments()->first();

        $this->assertNotNull($payment);
        $this->assertNotNull($purchasedSubscription);
        $this->assertTrue($purchasedSubscription->isActivated());
        $this->assertEquals($purchasedSubscription->payment, $payment);
    }

    public function test_payment_show_displays_not_completed_when_payment_not_succeeded()
    {
        $yookassaId = uniqid();
        $paymentUrl = 'https://www.example.com/confirmation_url';

        $mockResponse = Mockery::mock();
        $mockResponse->shouldReceive('getId')->andReturn($yookassaId);
        $mockResponse->shouldReceive('getStatus')->andReturn('pending');

        $mockPaymentMethod = Mockery::mock();
        $mockPaymentMethod->shouldReceive('getType')->andReturn('bank_card');

        $mockResponse->shouldReceive('getPaymentMethod')->andReturn($mockPaymentMethod);
        $mockResponse->shouldReceive('toArray')->andReturn(['status' => 'pending']);

        $mockGetConfirmation = Mockery::mock();
        $mockGetConfirmation->shouldReceive('getConfirmationUrl')
            ->andReturn($paymentUrl);

        $mockResponse->shouldReceive('getConfirmation')->andReturn($mockGetConfirmation);

        $this->yooKassaMock->shouldReceive('getPaymentInfo')
            ->with(Mockery::on(fn($id) => (string) $id === $yookassaId))
            ->andReturn($mockResponse);

        $payment = Payment::factory()
            ->create([
                'payment_provider' => PaymentProvider::YooKassa,
                'payment_id' => $yookassaId
            ]);

        $user = $payment->user;

        // Выполняем запрос
        $response = $this->actingAs($user)
            ->get(route('payments.show', ['payment' => $payment->id]))
            ->assertOk()
            ->assertViewIs('payments.not_completed')
            ->assertViewHas(['paymentUrl' => $paymentUrl])
            ->assertSee($paymentUrl)
            ->assertSeeText('Кажется, платеж не был завершён.')
            ->assertSeeText('Отказаться от оплаты');

        $payment->refresh();

        $this->assertEquals(PaymentStatusEnum::PENDING, $payment->status);
    }

    public function test_canceled_payment()
    {
        $yookassaId = uniqid();

        $mockResponse = Mockery::mock();
        $mockResponse->shouldReceive('getId')->andReturn($yookassaId);
        $mockResponse->shouldReceive('getStatus')->andReturn('canceled');

        $mockPaymentMethod = Mockery::mock();
        $mockPaymentMethod->shouldReceive('getType')->andReturn('bank_card');

        $mockResponse->shouldReceive('getPaymentMethod')->andReturn($mockPaymentMethod);
        $mockResponse->shouldReceive('toArray')->andReturn(['status' => 'pending']);

        $mockResponse->shouldReceive('getConfirmation')->andReturn(null);

        $this->yooKassaMock->shouldReceive('getPaymentInfo')
            ->with(Mockery::on(fn($id) => (string) $id === $yookassaId))
            ->andReturn($mockResponse);

        $payment = Payment::factory()
            ->create([
                'payment_provider' => PaymentProvider::YooKassa,
                'payment_id' => $yookassaId
            ]);

        $user = $payment->user;

        // Выполняем запрос
        $response = $this->actingAs($user)
            ->get(route('payments.show', ['payment' => $payment->id]))
            ->assertOk()
            ->assertViewIs('payments.not_completed')
            ->assertViewHas(['payment'])
            ->assertSeeText('Платеж был отменен')
            ->assertDontSeeText('Отказаться от оплаты');

        $payment->refresh();

        $this->assertEquals(PaymentStatusEnum::CANCELED, $payment->status);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
