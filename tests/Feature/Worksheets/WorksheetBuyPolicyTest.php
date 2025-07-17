<?php

namespace Tests\Feature\Worksheets;

use App\Enums\PaymentProvider;
use App\Models\User;
use App\Models\Worksheet;
use App\Models\Payment;
use App\Policies\WorksheetPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorksheetBuyPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_denies_if_worksheet_is_not_paid()
    {
        $user = User::factory()->create();
        $worksheet = Worksheet::factory()->free()->create();

        $response = (new WorksheetPolicy)->buy($user, $worksheet);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("The worksheet is not paid."), $response->message());
    }

    public function test_denies_if_user_is_staff()
    {
        $user = User::factory()->staff()->create();
        $worksheet = Worksheet::factory()->paid()->create();

        $response = (new WorksheetPolicy)->buy($user, $worksheet);
        $this->assertFalse($response->allowed());
        $this->assertEquals('', $response->message()); // метод возвращает deny() без сообщения
    }

    public function test_denies_if_user_has_active_subscription()
    {
        $user = User::factory()->withActiveSubscription()->create();
        $worksheet = Worksheet::factory()->paid()->create();

        $response = (new WorksheetPolicy)->buy($user, $worksheet);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("You can't buy it because you already have a subscription"), $response->message());
    }

    public function test_denies_if_already_purchased()
    {
        $user = User::factory()->withoutSubscription()->create();
        $worksheet = Worksheet::factory()->paid()->create();

        Payment::factory()
            ->forUser($user)
            ->withPurchase($worksheet)
            ->succeeded()
            ->create([
                'payment_provider' => PaymentProvider::RoboKassa
            ]);

        $response = (new WorksheetPolicy)->buy($user, $worksheet);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("You have already bought this product."), $response->message());
    }

    public function test_allows_if_paid_and_no_subscription_and_not_purchased()
    {
        $user = User::factory()->withoutSubscription()->create();
        $worksheet = Worksheet::factory()->paid()->create();

        $response = (new WorksheetPolicy)->buy($user, $worksheet);
        $this->assertTrue($response->allowed());
    }
}
