<?php

namespace Tests\Feature\Conferences;

use App\Models\Conference;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConferenceDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_a_conference()
    {
        $user = User::factory()
            ->staff()
            ->create();

        $conference = Conference::factory()
            ->create();

        $this->actingAs($user)
            ->delete(route('api.conferences.destroy', $conference))
            ->assertOk();

        $this->assertSoftDeleted($conference);

        $this->actingAs($user)
            ->delete(route('api.conferences.destroy', $conference))
            ->assertOk();

        $this->assertNotSoftDeleted($conference);
    }
}
