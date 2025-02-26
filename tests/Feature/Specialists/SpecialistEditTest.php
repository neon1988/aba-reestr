<?php

namespace Tests\Feature\Specialists;

use App\Models\Specialist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpecialistEditTest extends TestCase
{
    use RefreshDatabase;

    public function testShowMethod()
    {
        $user = User::factory()->create();

        $specialist = Specialist::factory()
            ->withUser($user)
            ->create();

        $response = $this->actingAs($user)
            ->get(route('specialists.edit', compact('specialist')))
            ->assertOk();
    }
}
