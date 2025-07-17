<?php

namespace Tests\Feature\Conferences;

use App\Models\User;
use App\Models\Conference;
use App\Models\Payment;
use App\Enums\PaymentProvider;
use App\Policies\ConferencePolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConferenceBuyPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_denies_if_conference_is_not_paid()
    {
        $user = User::factory()->create();
        $conference = Conference::factory()->free()->create();

        $response = (new ConferencePolicy)->buy($user, $conference);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("The conference is not paid."), $response->message());
    }

    public function test_denies_if_user_is_staff()
    {
        $user = User::factory()->staff()->create();
        $conference = Conference::factory()->paid()->create();

        $response = (new ConferencePolicy)->buy($user, $conference);
        $this->assertFalse($response->allowed());
        $this->assertNull($response->message());
    }

    public function test_denies_if_user_has_active_subscription()
    {
        $user = User::factory()->withActiveSubscription()->create();
        $conference = Conference::factory()->paid()->create();

        $response = (new ConferencePolicy)->buy($user, $conference);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("You can't buy it because you already have a subscription"), $response->message());
    }

    public function test_denies_if_user_already_purchased_conference()
    {
        $user = User::factory()->withoutSubscription()->create();
        $conference = Conference::factory()->paid()->create();

        Payment::factory()
            ->forUser($user)
            ->withPurchase($conference)
            ->succeeded()
            ->create([
                'payment_provider' => PaymentProvider::RoboKassa,
            ]);

        $response = (new ConferencePolicy)->buy($user, $conference);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("You have already bought this product."), $response->message());
    }

    public function test_allows_if_paid_and_user_can_buy()
    {
        $user = User::factory()->withoutSubscription()->create();
        $conference = Conference::factory()->paid()->create();

        $response = (new ConferencePolicy)->buy($user, $conference);
        $this->assertTrue($response->allowed());
    }
}
