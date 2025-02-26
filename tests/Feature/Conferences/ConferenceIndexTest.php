<?php

namespace Tests\Feature\Conferences;

use App\Models\Conference;
use App\Models\User;
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
