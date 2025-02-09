<?php

namespace Tests\Feature\Join;

use App\Enums\SubscriptionLevelEnum;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JoinControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Тестирование метода join
     *
     * @return void
     */
    public function testJoinMethod()
    {
        $user = User::factory()->create();

        $response = $this
            ->get(route('join'))
            ->assertOk()
            ->assertViewIs('join.join');
    }

    /**
     * Тестирование метода specialist
     *
     * @return void
     */
    public function testSpecialistMethod()
    {
        $user = User::factory()
            ->create([
                'subscription_level' => SubscriptionLevelEnum::B,
                'subscription_ends_at' => Carbon::now()->addYear()
            ]);

        $response = $this->actingAs($user)
            ->get(route('join.specialist'))
            ->assertOk()
            ->assertViewIs('join.specialist')
            ->assertViewHas('countries');
    }
}
