<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserIndexTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson(route('api.users.index'))
            ->assertOk();
    }

    public function testIndexWithSearchQuery()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson(route('api.users.index', ['search' => 'test']))
            ->assertOk();
    }
}
