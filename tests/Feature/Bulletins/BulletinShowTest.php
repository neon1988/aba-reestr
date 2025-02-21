<?php

namespace Feature\Bulletins;

use App\Models\Bulletin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BulletinShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_not_found()
    {
        $user = User::factory()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('bulletins.show', 1))
            ->assertNotFound();
    }
}
