<?php

namespace Tests\Feature\Conferences;

use App\Enums\SubscriptionLevelEnum;
use App\Models\Conference;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ConferenceSendInvitationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_user_can_send_invitations_and_get_redirect_response()
    {
        $user = User::factory()->staff()->create();

        $user2 = User::factory()
            ->create([
                'subscription_level' => SubscriptionLevelEnum::A,
                'subscription_ends_at' => Carbon::now()->addYears(1),
            ]);

        $conference = Conference::factory()
            ->create(['available_for_subscriptions' => [SubscriptionLevelEnum::A]]);

        $response = $this->actingAs($user)
            ->get(route('api.conferences.send-invitations', $conference))
            ->assertRedirect(route('conferences.show', $conference));

        $conference->refresh();
        $this->assertNotNull($conference->last_notified_at);
    }

    public function test_authorized_user_can_send_invitations_and_get_json_response()
    {
        $user = User::factory()->staff()->create();
        $conference = Conference::factory()->create();

        $response = $this->actingAs($user)
            ->getJson(route('api.conferences.send-invitations', $conference))
            ->assertOk()
            ->assertJsonStructure([
                'conference',
                'success'
            ])->assertJsonFragment([
                'success' => __('Invitations have been sent successfully')
            ]);
    }
}
