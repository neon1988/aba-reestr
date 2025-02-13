<?php

namespace Tests\Feature\Specialists;

use App\Enums\StatusEnum;
use App\Models\Specialist;
use App\Models\User;
use App\Notifications\SpecialistApprovedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SpecialistApproveTest extends TestCase
{
    use RefreshDatabase;

    public function test_specialist_can_be_approved_by_authorized_user()
    {
        Notification::fake();

        $admin = User::factory()
            ->staff()
            ->create();

        $specialist = Specialist::factory()
            ->withUser()
            ->create(['status' => StatusEnum::OnReview]);

        Cache::shouldReceive('forget')->once()->with('stats.specialistsCount');
        Cache::shouldReceive('forget')->once()->with('stats.specialistsOnReviewCount');

        $this->actingAs($admin)
            ->putJson(route('api.specialists.approve', $specialist))
            ->assertOk()
            ->assertJsonFragment([
                'message' => 'Специалист подтвержден'
            ]);

        $this->assertDatabaseHas('specialists', [
            'id' => $specialist->id,
            'status' => StatusEnum::Accepted,
        ]);

        $this->assertNotNull($specialist->users->first());

        Notification::assertSentTo($specialist->users->first(), SpecialistApprovedNotification::class);
    }
}
