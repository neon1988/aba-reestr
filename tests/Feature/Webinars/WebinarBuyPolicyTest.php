<?php

namespace Tests\Feature\Webinars;

use App\Models\User;
use App\Models\Webinar;
use App\Models\Payment;
use App\Enums\PaymentProvider;
use App\Policies\WebinarPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebinarBuyPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_denies_if_webinar_is_not_paid()
    {
        $user = User::factory()->create();
        $webinar = Webinar::factory()->free()->create();

        $response = (new WebinarPolicy)->buy($user, $webinar);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("The webinar is not paid."), $response->message());
    }

    public function test_denies_if_user_is_staff()
    {
        $user = User::factory()->staff()->create();
        $webinar = Webinar::factory()->paid()->create();

        $response = (new WebinarPolicy)->buy($user, $webinar);
        $this->assertFalse($response->allowed());
        $this->assertNull($response->message()); // Сообщение отсутствует
    }

    public function test_denies_if_user_has_active_subscription()
    {
        $user = User::factory()->withActiveSubscription()->create();
        $webinar = Webinar::factory()->paid()->create();

        $response = (new WebinarPolicy)->buy($user, $webinar);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("You can't buy it because you already have a subscription"), $response->message());
    }

    public function test_denies_if_webinar_already_purchased_by_user()
    {
        $user = User::factory()->withoutSubscription()->create();
        $webinar = Webinar::factory()->paid()->create();

        Payment::factory()
            ->forUser($user)
            ->withPurchase($webinar)
            ->succeeded()
            ->create([
                'payment_provider' => PaymentProvider::RoboKassa,
            ]);

        $response = (new WebinarPolicy)->buy($user, $webinar);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("You have already bought this product."), $response->message());
    }

    public function test_allows_if_paid_and_user_can_buy()
    {
        $user = User::factory()->withoutSubscription()->create();
        $webinar = Webinar::factory()->paid()->create();

        $response = (new WebinarPolicy)->buy($user, $webinar);
        $this->assertEquals(__(""), $response->message());
        $this->assertTrue($response->allowed());
    }
}
