<?php

namespace Tests\Feature\Webinars;

use App\Models\User;
use App\Models\Webinar;
use App\Models\Payment;
use App\Enums\PaymentProvider;
use App\Policies\WebinarPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebinarDownloadPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_allows_for_staff()
    {
        $user = User::factory()->staff()->create();
        $webinar = Webinar::factory()->paid()->create();

        $response = (new WebinarPolicy)->download($user, $webinar);
        $this->assertTrue($response->allowed());
    }

    public function test_allows_for_free_webinar()
    {
        $user = User::factory()->create();
        $webinar = Webinar::factory()->free()->create();

        $response = (new WebinarPolicy)->download($user, $webinar);
        $this->assertTrue($response->allowed());
    }

    public function test_allows_if_paid_and_purchased_by_user()
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

        $response = (new WebinarPolicy)->download($user, $webinar);
        $this->assertTrue($response->allowed());
    }

    public function test_denies_if_paid_and_no_subscription_and_not_purchased()
    {
        $user = User::factory()->withoutSubscription()->create();
        $webinar = Webinar::factory()->paid()->create();

        $response = (new WebinarPolicy)->download($user, $webinar);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("You don't have a subscription or your subscription is inactive."), $response->message());
    }

    public function test_allows_if_paid_and_subscription_active()
    {
        $user = User::factory()->withActiveSubscription()->create();
        $webinar = Webinar::factory()->paid()->create();

        $response = (new WebinarPolicy)->download($user, $webinar);
        $this->assertTrue($response->allowed());
    }
}
