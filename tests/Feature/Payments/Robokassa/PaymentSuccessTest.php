<?php

namespace Tests\Feature\Payments\Robokassa;

use App\Enums\PaymentProvider;
use App\Enums\PaymentStatusEnum;
use App\Models\Conference;
use App\Models\Payment;
use App\Models\User;
use App\Models\Webinar;
use App\Models\Worksheet;
use App\Services\RobokassaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class PaymentSuccessTest extends TestCase
{
    use RefreshDatabase;

    protected $robokassaService;

    protected function setUp(): void
    {
        parent::setUp();

        // Мокаем сервис
        $this->robokassaService = Mockery::mock(RobokassaService::class);
        $this->app->instance(RobokassaService::class, $this->robokassaService);
    }

    public function test_it_aborts_if_signature_invalid()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $payload = [
            'OutSum' => 100.50,
            'InvId' => 1,
            'SignatureValue' => 'wrong-signature'
        ];

        $this->robokassaService
            ->shouldReceive('isValidSuccessSignature')
            ->once()
            ->andReturn(false);

        $response = $this->get(route('robokassa.payments.success', $payload));

        $response->assertStatus(400);
        $response->assertSee('Invalid Robokassa signature');
    }

    public function test_it_updates_payment_and_redirects_to_webinar()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $webinar = Webinar::factory()->create();

        $payment = Payment::factory()->create([
            'id' => 10,
            'user_id' => $user->id,
            'payment_provider' => PaymentProvider::RoboKassa,
            'status' => PaymentStatusEnum::PENDING
        ]);

        // Добавляем покупку вебинара
        $payment->purchases()->create([
            'purchasable_id' => $webinar->id,
            'purchasable_type' => Webinar::class,
        ]);

        $payload = [
            'OutSum' => 100.50,
            'InvId' => $payment->id,
            'SignatureValue' => 'valid-signature'
        ];

        $this->robokassaService
            ->shouldReceive('isValidSuccessSignature')
            ->once()
            ->andReturn(true);

        $response = $this->get(route('robokassa.payments.success', $payload));

        $response->assertRedirect(route('webinars.show', $webinar));

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => PaymentStatusEnum::SUCCEEDED
        ]);
    }

    public function test_it_updates_payment_and_redirects_to_worksheet()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $worksheet = Worksheet::factory()->create();

        $payment = Payment::factory()->create([
            'id' => 10,
            'user_id' => $user->id,
            'payment_provider' => PaymentProvider::RoboKassa,
            'status' => PaymentStatusEnum::PENDING
        ]);

        // Добавляем покупку вебинара
        $payment->purchases()->create([
            'purchasable_id' => $worksheet->id,
            'purchasable_type' => Worksheet::class,
        ]);

        $payload = [
            'OutSum' => 100.50,
            'InvId' => $payment->id,
            'SignatureValue' => 'valid-signature'
        ];

        $this->robokassaService
            ->shouldReceive('isValidSuccessSignature')
            ->once()
            ->andReturn(true);

        $response = $this->get(route('robokassa.payments.success', $payload));

        $response->assertRedirect(route('worksheets.show', $worksheet));

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => PaymentStatusEnum::SUCCEEDED
        ]);
    }

    public function test_it_updates_payment_and_redirects_to_conference()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $conference = Conference::factory()->create();

        $payment = Payment::factory()->create([
            'id' => 10,
            'user_id' => $user->id,
            'payment_provider' => PaymentProvider::RoboKassa,
            'status' => PaymentStatusEnum::PENDING
        ]);

        // Добавляем покупку вебинара
        $payment->purchases()->create([
            'purchasable_id' => $conference->id,
            'purchasable_type' => Conference::class,
        ]);

        $payload = [
            'OutSum' => 100.50,
            'InvId' => $payment->id,
            'SignatureValue' => 'valid-signature'
        ];

        $this->robokassaService
            ->shouldReceive('isValidSuccessSignature')
            ->once()
            ->andReturn(true);

        $response = $this->get(route('robokassa.payments.success', $payload));

        $response->assertRedirect(route('conferences.show', $conference));

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => PaymentStatusEnum::SUCCEEDED
        ]);
    }

    public function test_it_returns_success_view_if_no_purchases()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $payment = Payment::factory()->create([
            'user_id' => $user->id,
            'payment_provider' => PaymentProvider::RoboKassa,
            'status' => PaymentStatusEnum::PENDING
        ]);

        $payload = [
            'OutSum' => 100,
            'InvId' => $payment->id,
            'SignatureValue' => 'valid-signature'
        ];

        $this->robokassaService
            ->shouldReceive('isValidSuccessSignature')
            ->once()
            ->andReturn(true);

        $response = $this->get(route('robokassa.payments.success', $payload));

        $response->assertViewIs('payments.success');
    }
}
