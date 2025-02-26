<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_not_found()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('users.show', 1))
            ->assertOk();
    }
}
