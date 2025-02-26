<?php

namespace Tests\Feature\Webinars;

use App\Enums\SubscriptionLevelEnum;
use App\Models\User;
use App\Models\Webinar;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebinarShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_without_subscription()
    {
        $user = User::factory()
            ->create([
                'subscription_level' => SubscriptionLevelEnum::Free
            ]);;

        $webinar = Webinar::factory()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('webinars.show', $webinar))
            ->assertOk();
    }

    public function test_show_with_subscription_level()
    {
        $user = User::factory()
            ->create([
                'subscription_level' => SubscriptionLevelEnum::A,
                'subscription_ends_at' => Carbon::now()->addYear()
            ]);;

        $webinar = Webinar::factory()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('webinars.show', $webinar))
            ->assertOk();
    }

    public function test_not_found()
    {
        $user = User::factory()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('webinars.show', 1))
            ->assertNotFound();
    }
}
