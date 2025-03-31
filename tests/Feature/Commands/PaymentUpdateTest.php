<?php

namespace Tests\Feature\Commands;

use App\Enums\PaymentProvider;
use App\Enums\PaymentStatusEnum;
use App\Models\Payment;
use App\Services\RobokassaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class PaymentUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_payment_successfully()
    {
        $payment = Payment::factory()->create([
            'payment_provider' => PaymentProvider::RoboKassa,
            'payment_id' => '123456',
        ]);

        $mockService = Mockery::mock(RobokassaService::class);
        $mockService->shouldReceive('checkPaymentStatus')
            ->with('123456')
            ->once()
            ->andReturn([
                'Result' => ['Code' => 0],
                'Info' => ['OutSum' => 1000],
            ]);

        $this->app->instance(RobokassaService::class, $mockService);

        $this->artisan('payments:update', ['id' => $payment->id])
            ->assertExitCode(0);

        $payment->refresh();
        $this->assertEquals(1000, $payment->amount);
        $this->assertEquals(PaymentStatusEnum::SUCCEEDED, $payment->status);
    }

    public function test_it_marks_payment_as_canceled()
    {
        $payment = Payment::factory()->create([
            'payment_provider' => PaymentProvider::RoboKassa,
            'payment_id' => '123456',
        ]);

        $mockService = Mockery::mock(RobokassaService::class);
        $mockService->shouldReceive('checkPaymentStatus')
            ->with('123456')
            ->once()
            ->andReturn([
                'Result' => ['Code' => 3],
                'Info' => []
            ]);

        $this->app->instance(RobokassaService::class, $mockService);

        $this->artisan('payments:update', ['id' => $payment->id])
            ->assertExitCode(0);

        $payment->refresh();
        $this->assertEquals(PaymentStatusEnum::CANCELED, $payment->status);
    }
}
