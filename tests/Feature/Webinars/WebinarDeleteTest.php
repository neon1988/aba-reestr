<?php

namespace Tests\Feature\Webinars;

use App\Models\User;
use App\Models\Webinar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebinarDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_a_webinar()
    {
        $user = User::factory()
            ->staff()
            ->create();

        $webinar = Webinar::factory()
            ->create();

        $this->actingAs($user)
            ->delete(route('api.webinars.destroy', $webinar))
            ->assertOk();

        $this->assertSoftDeleted($webinar);

        $this->actingAs($user)
            ->delete(route('api.webinars.destroy', $webinar))
            ->assertOk();

        $this->assertNotSoftDeleted($webinar);
    }
}
