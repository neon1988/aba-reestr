<?php

namespace Tests\Feature\Specialists;

use App\Enums\SubscriptionLevelEnum;
use App\Models\Specialist;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\WorldSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpecialistLocationAndWorkTest extends TestCase
{
    use RefreshDatabase;

    public function testShow()
    {
        $this->seed(WorldSeeder::class);

        $user = User::factory()->create([
            'subscription_level' => SubscriptionLevelEnum::B,
            'subscription_ends_at' => Carbon::now()->addYear()
        ]);

        $specialist = Specialist::factory()
            ->withUser($user)
            ->create();

        $response = $this->actingAs($user)
            ->get(route('specialists.location-and-work', compact('specialist')))
            ->assertOk();
    }

    public function testUpdate()
    {
        $this->seed(WorldSeeder::class);

        $user = User::factory()->create([
            'subscription_level' => SubscriptionLevelEnum::B,
            'subscription_ends_at' => Carbon::now()->addYear()
        ]);

        $specialist = Specialist::factory()
            ->withUser($user)
            ->create();

        $specialistArray = Specialist::factory()
            ->make()
            ->toArray();
        unset($specialistArray['status']);
        unset($specialistArray['create_user_id']);

        $response = $this->actingAs($user)
            ->patch(route('specialists.location-and-work.update', compact('specialist')), $specialistArray)
            ->assertSessionHasNoErrors()
            ->assertRedirect()
            ->assertSessionHas('success', 'Профиль специалиста обновлен.');

        $specialist->refresh();
    }
}
