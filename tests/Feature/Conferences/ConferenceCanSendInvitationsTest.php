<?php

namespace Tests\Feature\Conferences;

use App\Models\Conference;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConferenceCanSendInvitationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can()
    {
        $user = User::factory()
            ->staff()
            ->create();

        $conference = Conference::factory()
            ->create();

        $this->assertTrue($user->can('sendInvitations', $conference));
    }

    public function test_cant_if_not_staff()
    {
        $user = User::factory()
            ->create();

        $conference = Conference::factory()
            ->create();

        $this->assertFalse($user->can('sendInvitations', $conference));
    }

    public function test_cant_if_url_empty()
    {
        $user = User::factory()
            ->staff()
            ->create();

        $conference = Conference::factory()
            ->create(['registration_url' => '']);

        $this->assertFalse($user->can('sendInvitations', $conference));
    }

    public function test_cant_if_ended()
    {
        $user = User::factory()
            ->staff()
            ->create();

        $conference = Conference::factory()
            ->ended()
            ->create();

        $this->assertFalse($user->can('sendInvitations', $conference));
    }
}
