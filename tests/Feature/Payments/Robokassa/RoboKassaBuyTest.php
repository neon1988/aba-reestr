<?php

namespace Tests\Feature\Payments\Robokassa;

use App\Enums\PaymentProvider;
use App\Enums\PaymentStatusEnum;
use App\Models\Conference;
use App\Models\User;
use App\Models\Webinar;
use App\Models\Worksheet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Mockery;
use Tests\TestCase;

class RoboKassaBuyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()
            ->withoutSubscription()
            ->create();
    }

    public function test_buy_worksheet()
    {
        $this->actingAs($this->user);

        $worksheet = Worksheet::factory()
            ->paid()
            ->create();

        $this->assertTrue($this->user->can('buy', $worksheet));

        // Мок сервиса оплаты, чтобы не делать реальный запрос
        $robokassaMock = Mockery::mock(\App\Services\RobokassaService::class);
        $this->app->instance(\App\Services\RobokassaService::class, $robokassaMock);

        $description = 'Доступ к материалу "'.$worksheet->title.'"';

        // Ожидаемые параметры платежа
        $expectedPaymentData = [
            "items" => [
                [
                    "name" => $description,
                    "quantity" => 1,
                    "sum" => $worksheet->price,
                    "payment_method" => "full_payment",
                    "payment_object" => "service",
                    "tax" => "none"
                ]
            ]
        ];

        $paymentId = Str::uuid();
        $robokassaMock->shouldReceive('createPayment')
            ->once()
            ->withArgs(function ($amount, $id, $desc, $data) use ($worksheet, $expectedPaymentData, $description) {
                return $amount === $worksheet->price
                    && $desc === $description
                    && $data == $expectedPaymentData;
            })
            ->andReturn("https://robokassa.test/payment/{$paymentId}");

        $response = $this->get(route('robokassa.buy', ['type' => 'worksheet', 'id' => $worksheet->id]))
            ->assertRedirect();

        $payment = $this->user->payments()->first();

        $this->assertNotNull($payment);
        $this->assertEquals($this->user->id, $payment->user_id);
        $this->assertEquals($worksheet->price, $payment->amount);
        $this->assertEquals(PaymentProvider::RoboKassa, $payment->payment_provider);
        $this->assertEquals(PaymentStatusEnum::PENDING, $payment->status);
        $this->assertEquals($payment->id, $payment->payment_id);

        $purchases = $payment->purchases()->get();

        $this->assertEquals(1, $purchases->count());

        $purchase = $purchases->first();

        $this->assertNotNull($purchase);
        $this->assertNotNull($purchase->purchasable);
        $this->assertEquals('worksheet', $purchase->purchasable_type);
        $this->assertEquals(1, $purchase->purchasable_id);
        $this->assertTrue($purchase->is($purchase->purchasable->purchases()->first()));

        // Проверяем, что был редирект на страницу оплаты
        $response->assertRedirect("https://robokassa.test/payment/{$paymentId}");
    }

    public function test_buy_conference()
    {
        $this->actingAs($this->user);

        $conference = Conference::factory()
            ->paid()
            ->create();

        $this->assertTrue($this->user->can('buy', $conference));

        // Мок сервиса оплаты, чтобы не делать реальный запрос
        $robokassaMock = Mockery::mock(\App\Services\RobokassaService::class);
        $this->app->instance(\App\Services\RobokassaService::class, $robokassaMock);

        $description = 'Доступ к мероприятию "'.$conference->title.'"';

        // Ожидаемые параметры платежа
        $expectedPaymentData = [
            "items" => [
                [
                    "name" => $description,
                    "quantity" => 1,
                    "sum" => $conference->price,
                    "payment_method" => "full_payment",
                    "payment_object" => "service",
                    "tax" => "none"
                ]
            ]
        ];

        $paymentId = Str::uuid();
        $robokassaMock->shouldReceive('createPayment')
            ->once()
            ->withArgs(function ($amount, $id, $desc, $data) use ($conference, $expectedPaymentData, $description) {
                return $amount === $conference->price
                    && $desc === $description
                    && $data == $expectedPaymentData;
            })
            ->andReturn("https://robokassa.test/payment/{$paymentId}");

        $response = $this->get(route('robokassa.buy', ['type' => 'conference', 'id' => $conference->id]))
            ->assertRedirect();

        $payment = $this->user->payments()->first();

        $this->assertNotNull($payment);
        $this->assertEquals($this->user->id, $payment->user_id);
        $this->assertEquals($conference->price, $payment->amount);
        $this->assertEquals(PaymentProvider::RoboKassa, $payment->payment_provider);
        $this->assertEquals(PaymentStatusEnum::PENDING, $payment->status);
        $this->assertEquals($payment->id, $payment->payment_id);

        $purchases = $payment->purchases()->get();

        $this->assertEquals(1, $purchases->count());

        $purchase = $purchases->first();

        $this->assertNotNull($purchase);
        $this->assertNotNull($purchase->purchasable);
        $this->assertEquals('conference', $purchase->purchasable_type);
        $this->assertEquals(1, $purchase->purchasable_id);

        // Проверяем, что был редирект на страницу оплаты
        $response->assertRedirect("https://robokassa.test/payment/{$paymentId}");
    }

    public function test_buy_webinar()
    {
        $this->actingAs($this->user);

        $webinar = Webinar::factory()
            ->paid()
            ->create();

        $this->assertTrue($this->user->can('buy', $webinar));

        // Мок сервиса оплаты, чтобы не делать реальный запрос
        $robokassaMock = Mockery::mock(\App\Services\RobokassaService::class);
        $this->app->instance(\App\Services\RobokassaService::class, $robokassaMock);

        $description = 'Доступ к вебинару "'.$webinar->title.'"';

        // Ожидаемые параметры платежа
        $expectedPaymentData = [
            "items" => [
                [
                    "name" => $description,
                    "quantity" => 1,
                    "sum" => $webinar->price,
                    "payment_method" => "full_payment",
                    "payment_object" => "service",
                    "tax" => "none"
                ]
            ]
        ];

        $paymentId = Str::uuid();
        $robokassaMock->shouldReceive('createPayment')
            ->once()
            ->withArgs(function ($amount, $id, $desc, $data) use ($webinar, $expectedPaymentData, $description) {
                return $amount === $webinar->price
                    && $desc === $description
                    && $data == $expectedPaymentData;
            })
            ->andReturn("https://robokassa.test/payment/{$paymentId}");

        $response = $this->get(route('robokassa.buy', ['type' => 'webinar', 'id' => $webinar->id]))
            ->assertRedirect();

        $payment = $this->user->payments()->first();

        $this->assertNotNull($payment);
        $this->assertEquals($this->user->id, $payment->user_id);
        $this->assertEquals($webinar->price, $payment->amount);
        $this->assertEquals(PaymentProvider::RoboKassa, $payment->payment_provider);
        $this->assertEquals(PaymentStatusEnum::PENDING, $payment->status);
        $this->assertEquals($payment->id, $payment->payment_id);

        $purchases = $payment->purchases()->get();

        $this->assertEquals(1, $purchases->count());

        $purchase = $purchases->first();

        $this->assertNotNull($purchase);
        $this->assertNotNull($purchase->purchasable);
        $this->assertEquals('webinar', $purchase->purchasable_type);
        $this->assertEquals(1, $purchase->purchasable_id);

        // Проверяем, что был редирект на страницу оплаты
        $response->assertRedirect("https://robokassa.test/payment/{$paymentId}");
    }
}
