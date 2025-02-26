<?php

namespace Tests\Feature\Specialists;

use App\Models\Specialist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpecialistsShowTest extends TestCase
{
    use RefreshDatabase;

    public function testShowMethod()
    {
        $user = User::factory()->create();

        $specialist = Specialist::factory()
            ->withUser($user)
            ->create();

        $response = $this->actingAs($user)
            ->get(route('specialists.show', compact('specialist')))
            ->assertOk();
    }

    public function test_not_found()
    {
        $user = User::factory()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('specialists.show', 1))
            ->assertNotFound();
    }
}
