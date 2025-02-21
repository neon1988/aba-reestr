<?php

namespace Feature\Conferences;

use App\Enums\SubscriptionLevelEnum;
use App\Models\Conference;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConferenceIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_show()
    {
        $user = User::factory()
            ->create();

        $conference = Conference::factory()
            ->create();

        $conference2 = Conference::factory()
            ->ended()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('conferences.index'))
            ->assertOk();
    }
}
