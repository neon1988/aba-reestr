<?php

namespace Tests\Feature\Specialists;

use App\Enums\SubscriptionLevelEnum;
use App\Models\Specialist;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\WorldSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpecialistEducationAndDocumentsTest extends TestCase
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
            ->get(route('specialists.education-and-documents', compact('specialist')))
            ->assertOk();
    }

}
