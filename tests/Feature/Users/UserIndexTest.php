<?php

namespace Feature\Users;

use App\Enums\SubscriptionLevelEnum;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserIndexTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function testIndex()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson(route('api.users.index'))
            ->assertOk();
    }
}
