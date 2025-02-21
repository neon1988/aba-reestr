<?php

namespace Feature\Worksheets;

use App\Enums\SubscriptionLevelEnum;
use App\Models\User;
use App\Models\Worksheet;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorksheetIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_show()
    {
        $user = User::factory()
            ->create();

        $worksheet = Worksheet::factory()
            ->create();

        $worksheet2 = Worksheet::factory()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('worksheets.index', $worksheet))
            ->assertOk();
    }
}
