<?php

namespace Feature\Worksheets;

use App\Models\User;
use App\Models\Worksheet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorksheetDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_a_worksheet()
    {
        $user = User::factory()
            ->staff()
            ->create();

        $worksheet = Worksheet::factory()
            ->create();

        $this->actingAs($user)
            ->delete(route('api.worksheets.destroy', $worksheet))
            ->assertOk();

        $this->assertSoftDeleted($worksheet);

        $this->actingAs($user)
            ->delete(route('api.worksheets.destroy', $worksheet))
            ->assertOk();

        $this->assertNotSoftDeleted($worksheet);
    }
}
