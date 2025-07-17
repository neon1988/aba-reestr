<?php

namespace Tests\Feature\Commands;

use App\Models\Payment;
use App\Enums\PaymentStatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class PaymentUpdateBatchTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_not_update_any_payments_if_no_payments_older_than_specified_time()
    {
        // Создаем платеж, который был создан только что (например, сейчас)
        Payment::factory()->create([
            'status' => PaymentStatusEnum::PENDING,
            'created_at' => Carbon::now(),
        ]);

        // Выполняем команду с ограничением 30 минут
        $this->artisan('payments:batch-update', ['minutes' => 30])
            ->expectsOutput('Нет платежей для обновления.')
            ->assertExitCode(0);
    }
}
