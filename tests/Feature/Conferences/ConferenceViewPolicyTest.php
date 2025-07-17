<?php

namespace Tests\Feature\Conferences;

use App\Enums\SubscriptionLevelEnum;
use App\Models\User;
use App\Models\Conference;
use App\Models\Payment;
use App\Enums\PaymentProvider;
use App\Policies\ConferencePolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConferenceViewPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_allows_for_staff()
    {
        $user = User::factory()->staff()->create();
        $conference = Conference::factory()->paid()->create();

        $response = (new ConferencePolicy)->view($user, $conference);
        $this->assertTrue($response->allowed());
    }

    public function test_allows_for_free_conference()
    {
        $user = User::factory()->create();
        $conference = Conference::factory()->free()->create();

        $response = (new ConferencePolicy)->view($user, $conference);
        $this->assertTrue($response->allowed());
    }

    public function test_denies_if_paid_and_no_subscription_and_not_purchased()
    {
        $user = User::factory()->withoutSubscription()->create();
        $conference = Conference::factory()->paid()->create();

        $response = (new ConferencePolicy)->view($user, $conference);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("You don't have a subscription or your subscription is inactive."), $response->message());
    }

    public function test_denies_if_paid_and_has_subscription_but_not_available_for_level()
    {
        $user = User::factory()->withActiveSubscription(SubscriptionLevelEnum::A)->create();
        $conference = Conference::factory()->paid()->withRequiredLevel(SubscriptionLevelEnum::C)->create();

        $response = (new ConferencePolicy)->view($user, $conference);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("Unavailable for your subscription"), $response->message());
    }

    public function test_allows_if_paid_and_purchased_by_user()
    {
        $user = User::factory()->withoutSubscription()->create();
        $conference = Conference::factory()->paid()->create();

        Payment::factory()
            ->forUser($user)
            ->withPurchase($conference)
            ->succeeded()
            ->create([
                'payment_provider' => PaymentProvider::RoboKassa
            ]);

        $response = (new ConferencePolicy)->view($user, $conference);
        $this->assertTrue($response->allowed());
    }

    public function test_allows_if_paid_and_subscription_is_active_and_level_is_sufficient()
    {
        $user = User::factory()->withActiveSubscription(SubscriptionLevelEnum::C)->create();
        $conference = Conference::factory()->paid()->withRequiredLevel(SubscriptionLevelEnum::C)->create();

        $response = (new ConferencePolicy)->view($user, $conference);
        $this->assertTrue($response->allowed());
    }
}
