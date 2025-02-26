<?php

namespace Tests\Feature\Bulletins;

use App\Models\Bulletin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BulletinIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_show()
    {
        $user = User::factory()
            ->create();

        $bulletin = Bulletin::factory()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('bulletins.index'))
            ->assertOk();
    }
}
