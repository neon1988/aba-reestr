<?php

namespace Tests\Feature\Worksheets;

use App\Enums\SubscriptionLevelEnum;
use App\Models\User;
use App\Models\Worksheet;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorksheetShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_without_subscription()
    {
        $user = User::factory()
            ->create([
                'subscription_level' => SubscriptionLevelEnum::Free
            ]);

        $worksheet = Worksheet::factory()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('worksheets.show', $worksheet))
            ->assertOk();
    }

    public function test_show_with_subscription_level()
    {
        $user = User::factory()
            ->create([
                'subscription_level' => SubscriptionLevelEnum::A,
                'subscription_ends_at' => Carbon::now()->addYear()
            ]);

        $worksheet = Worksheet::factory()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('worksheets.show', $worksheet))
            ->assertOk();
    }

    public function test_not_found()
    {
        $user = User::factory()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('worksheets.show', 1))
            ->assertNotFound();
    }
}
