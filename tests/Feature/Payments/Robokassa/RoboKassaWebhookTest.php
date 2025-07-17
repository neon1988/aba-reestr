<?php

namespace Tests\Feature\Payments\Robokassa;

use App\Enums\PaymentProvider;
use App\Enums\PaymentStatusEnum;
use App\Http\Controllers\RobokassaController;
use App\Models\Payment;
use App\Models\PurchasedSubscription;
use App\Models\User;
use App\Services\RobokassaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class RoboKassaWebhookTest extends TestCase
{
    use RefreshDatabase;

    protected \Mockery\MockInterface $robokassaServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Мокаем сервис Robokassa
        $this->robokassaServiceMock = $this->mock(RobokassaService::class);
    }

    public function test_it_rejects_invalid_ip()
    {
        $this->robokassaServiceMock
            ->shouldReceive('isValidIP')
            ->with('invalid-ip')
            ->andReturn(false);

        $this->get(route('robokassa.webhook'), ['REMOTE_ADDR' => 'invalid-ip'])
            ->assertForbidden();
    }

    public function test_it_validates_webhook_data()
    {
        $request = Request::create('/webhook', 'POST', [
            'OutSum' => 'invalid', // invalid data type
            'InvId' => '55',
            'crc' => '2745738D76E6E357D5A9FEF3FCB916C7',
            'Fee' => 0.03,
            'SignatureValue' => '2745738D76E6E357D5A9FEF3FCB916C7',
            'IncSum' => 1.00,
            'IncCurrLabel' => 'SBPPSR',
        ]);

        $this->robokassaServiceMock
            ->shouldReceive('isValidIP')
            ->with($request->ip())
            ->andReturn(true);

        $this->expectException(ValidationException::class);

        $controller = new RobokassaController($this->robokassaServiceMock);
        $controller->handleWebhook($request);
    }

    public function test_it_rejects_invalid_signature()
    {
        $request = Request::create('/webhook', 'POST', [
            'OutSum' => 1.00,
            'InvId' => '55',
            'crc' => '2745738D76E6E357D5A9FEF3FCB916C7',
            'Fee' => 0.03,
            'SignatureValue' => 'invalid-signature', // invalid signature
            'IncSum' => 1.00,
            'IncCurrLabel' => 'SBPPSR',
        ]);

        $this->robokassaServiceMock
            ->shouldReceive('isValidIP')
            ->with($request->ip())
            ->andReturn(true);

        $this->robokassaServiceMock
            ->shouldReceive('isValidResultSignature')
            ->with($request->all())
            ->andReturn(false);

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
        $this->expectExceptionMessage('Invalid Robokassa signature');

        $controller = new RobokassaController($this->robokassaServiceMock);
        $controller->handleWebhook($request);
    }

    public function test_it_updates_payment_and_returns_ok()
    {
        $user = User::factory()
            ->withoutSubscription()
            ->create();

        $payment = Payment::factory()
            ->forUser($user)
            ->withSubscription()
            ->create([
                'payment_provider' => PaymentProvider::RoboKassa
            ]);

        $request = Request::create('/webhook', 'POST', [
            'OutSum' => 1.00,
            'InvId' => $payment->id,
            'crc' => '2745738D76E6E357D5A9FEF3FCB916C7',
            'Fee' => 0.03,
            'SignatureValue' => '2745738D76E6E357D5A9FEF3FCB916C7',
            'IncSum' => 1.00,
            'IncCurrLabel' => 'SBPPSR',
            'PaymentMethod' => 'PayButton'
        ]);

        $this->robokassaServiceMock
            ->shouldReceive('isValidIP')
            ->with($request->ip())
            ->andReturn(true);

        $this->robokassaServiceMock
            ->shouldReceive('isValidResultSignature')
            ->with($request->all())
            ->andReturn(true);

        $this->assertFalse($user->isSubscriptionActive());

        $controller = new RobokassaController($this->robokassaServiceMock);
        $response = $controller->handleWebhook($request);

        $payment->refresh();

        $this->assertEquals('OK' . $payment->id, $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(PaymentStatusEnum::SUCCEEDED, $payment->status);
        $this->assertEquals('PayButton', $payment->payment_method);

        $user->refresh();

        $subscription = $payment->purchases()->first()->purchasable;

        $this->assertInstanceOf(PurchasedSubscription::class, $subscription);
        $this->assertNotNull($subscription);
        $this->assertTrue($subscription->isActivated());

        $this->assertTrue($user->isSubscriptionActive());
    }
}
