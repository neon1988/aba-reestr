<?php

namespace Feature\Webinars;

use App\Enums\SubscriptionLevelEnum;
use App\Models\User;
use App\Models\Webinar;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebinarIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_show()
    {
        $user = User::factory()
            ->create();

        $webinar = Webinar::factory()
            ->create();

        $webinar2 = Webinar::factory()
            ->ended()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('webinars.index', $webinar))
            ->assertOk();
    }
}
