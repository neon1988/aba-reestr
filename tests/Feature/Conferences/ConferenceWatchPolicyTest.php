<?php

namespace Tests\Feature\Conferences;

use App\Enums\SubscriptionLevelEnum;
use App\Models\File;
use App\Models\User;
use App\Models\Conference;
use App\Models\Payment;
use App\Enums\PaymentProvider;
use App\Policies\ConferencePolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConferenceWatchPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_denies_if_no_record_file()
    {
        $user = User::factory()->create();
        $conference = Conference::factory()->paid()->withoutRecord()->create();

        $response = (new ConferencePolicy)->watch($user, $conference);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("The conference has no record."), $response->message());
    }

    public function test_denies_if_file_is_not_video()
    {
        $user = User::factory()->create();
        $file = File::factory()->pdf()->create();
        $conference = Conference::factory()->paid()->withFile($file)->create(); // имитация не видео

        $response = (new ConferencePolicy)->watch($user, $conference);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("You can only watch it if the file is a video file."), $response->message());
    }

    public function test_allows_for_staff_even_if_paid()
    {
        $user = User::factory()->staff()->create();
        $file = File::factory()->video()->create();
        $conference = Conference::factory()->paid()->withFile($file)->create();

        $response = (new ConferencePolicy)->watch($user, $conference);
        $this->assertTrue($response->allowed());
    }

    public function test_denies_if_paid_and_no_subscription_and_not_purchased()
    {
        $user = User::factory()->withoutSubscription()->create();
        $file = File::factory()->video()->create();
        $conference = Conference::factory()->paid()->withFile($file)->create();

        $response = (new ConferencePolicy)->watch($user, $conference);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("You don't have a subscription or your subscription is inactive."), $response->message());
    }

    public function test_denies_if_paid_and_subscription_active_but_level_is_insufficient()
    {
        $user = User::factory()->withActiveSubscription(SubscriptionLevelEnum::A)->create();
        $file = File::factory()->video()->create();
        $conference = Conference::factory()->paid()->withFile($file)->withRequiredLevel(SubscriptionLevelEnum::C)->create();

        $response = (new ConferencePolicy)->watch($user, $conference);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("Unavailable for your subscription"), $response->message());
    }

    public function test_allows_if_paid_and_purchased_by_user()
    {
        $user = User::factory()->withoutSubscription()->create();
        $file = File::factory()->video()->create();
        $conference = Conference::factory()->paid()->withFile($file)->create();

        Payment::factory()
            ->forUser($user)
            ->withPurchase($conference)
            ->succeeded()
            ->create([
                'payment_provider' => PaymentProvider::RoboKassa
            ]);

        $response = (new ConferencePolicy)->watch($user, $conference);
        $this->assertTrue($response->allowed());
    }

    public function test_allows_if_paid_and_subscription_active_and_level_sufficient()
    {
        $user = User::factory()->withActiveSubscription(SubscriptionLevelEnum::C)->create();
        $file = File::factory()->video()->create();
        $conference = Conference::factory()->paid()->withFile($file)->withRequiredLevel(SubscriptionLevelEnum::C)->create();

        $response = (new ConferencePolicy)->watch($user, $conference);
        $this->assertTrue($response->allowed());
    }

    public function test_allows_for_free_conference_with_record()
    {
        $user = User::factory()->create();
        $file = File::factory()->video()->create();
        $conference = Conference::factory()->free()->withFile($file)->create();

        $response = (new ConferencePolicy)->watch($user, $conference);
        $this->assertTrue($response->allowed());
    }
}
