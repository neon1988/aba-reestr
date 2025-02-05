<?php

namespace Tests\Feature\Payments\YooKassa;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class YooKassaPaymentReturnTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_return_redirects_to_payment_show_when_yookassa_id_exists()
    {
        $user = User::factory()->create();
        $idempotenceKey = 'test-uuid';
        $yookassaId = 'payment-123';

        // Устанавливаем нужные данные в сессии
        Session::put("payments.$idempotenceKey.yookassa_id", $yookassaId);

        // Выполняем запрос
        $response = $this->actingAs($user)
            ->get(route('yookassa.payment.return', ['uuid' => $idempotenceKey]))
            ->assertRedirect(route('yookassa.payment.show', ['yookassa_id' => $yookassaId]));
    }

    public function test_payment_return_redirects_to_join_when_yookassa_id_missing()
    {
        $user = User::factory()->create();
        $idempotenceKey = 'test-uuid';

        // Выполняем запрос
        $response = $this->actingAs($user)
            ->get(route('yookassa.payment.return', ['uuid' => $idempotenceKey]))
            ->assertRedirect(route('join'));
    }


}
