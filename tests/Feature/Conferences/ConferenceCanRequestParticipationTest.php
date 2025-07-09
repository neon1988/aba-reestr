<?php

namespace Tests\Feature\Conferences;

use App\Enums\SubscriptionLevelEnum;
use App\Models\Conference;
use App\Models\File;
use App\Models\User;
use App\Policies\ConferencePolicy;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConferenceCanRequestParticipationTest extends TestCase
{
    use RefreshDatabase;

    public function test_denies_if_no_registration_url()
    {
        $user = User::factory()->create();
        $conference = Conference::factory()->create(['registration_url' => null]);

        $response = (new ConferencePolicy)->requestParticipation($user, $conference);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("There is no registration link in this conference."), $response->message());
    }

    public function test_denies_if_conference_ended()
    {
        $user = User::factory()->create();
        $conference = Conference::factory()->ended()->create([
            'registration_url' => 'https://example.com',
        ]);

        $response = (new ConferencePolicy)->requestParticipation($user, $conference);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("The conference is ended"), $response->message());
    }

    public function test_denies_if_has_record_file()
    {
        $user = User::factory()->create();
        $conference = Conference::factory()->create([
            'registration_url' => 'https://example.com',
            'file_id' => File::factory()->create(),
        ]);

        $response = (new ConferencePolicy)->requestParticipation($user, $conference);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("The conference is already on the record"), $response->message());
    }

    public function test_allows_for_staff()
    {
        $user = User::factory()->staff()->create();
        $conference = Conference::factory()->create([
            'registration_url' => 'https://example.com',
        ]);

        $response = (new ConferencePolicy)->requestParticipation($user, $conference);
        $this->assertTrue($response->allowed());
    }

    public function test_denies_if_paid_and_no_active_subscription()
    {
        $user = User::factory()
            ->withInactiveSubscription(SubscriptionLevelEnum::A)
            ->create();

        $conference = Conference::factory()->create([
            'price' => 42,
            'registration_url' => 'https://example.com',
            'available_for_subscriptions' => [SubscriptionLevelEnum::A, SubscriptionLevelEnum::B],
        ]);

        $response = (new ConferencePolicy)->requestParticipation($user, $conference);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("You don't have a subscription or your subscription is inactive."), $response->message());
    }

    public function test_denies_if_paid_and_not_in_available_subscriptions()
    {
        $user = User::factory()
            ->withActiveSubscription(SubscriptionLevelEnum::C)
            ->create();

        $conference = Conference::factory()->paid()->create([
            'registration_url' => 'https://example.com',
            'available_for_subscriptions' => [SubscriptionLevelEnum::A, SubscriptionLevelEnum::B],
        ]);

        $response = (new ConferencePolicy)->requestParticipation($user, $conference);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("Unavailable for your subscription"), $response->message());
    }

    public function test_allows_for_paid_and_allowed_subscription()
    {
        $user = User::factory()
            ->withActiveSubscription(SubscriptionLevelEnum::B)
            ->create();

        $conference = Conference::factory()->paid()->create([
            'registration_url' => 'https://example.com',
            'available_for_subscriptions' => [SubscriptionLevelEnum::B],
        ]);

        $response = (new ConferencePolicy)->requestParticipation($user, $conference);
        $this->assertTrue($response->allowed());
    }

    public function test_allows_for_free_conference()
    {
        $user = User::factory()->create();
        $conference = Conference::factory()->free()->create([
            'registration_url' => 'https://example.com',
        ]);

        $response = (new ConferencePolicy)->requestParticipation($user, $conference);
        $this->assertTrue($response->allowed());
    }
}
