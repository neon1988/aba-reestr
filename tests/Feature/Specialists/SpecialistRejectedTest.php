<?php

namespace Tests\Feature\Specialists;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use App\Models\Specialist;
use App\Models\User;
use App\Enums\StatusEnum;
use App\Notifications\SpecialistRejectedNotification;

class SpecialistRejectedTest extends TestCase
{
    use RefreshDatabase;

    public function test_specialist_can_be_rejected_by_authorized_user()
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
            ->putJson(route('api.specialists.reject', $specialist))
            ->assertOk()
            ->assertJsonFragment([
                'message' => 'Специалист отклонен'
            ]);

        $this->assertDatabaseHas('specialists', [
            'id' => $specialist->id,
            'status' => StatusEnum::Rejected,
        ]);

        $this->assertTrue($specialist->users()->exists());

        Notification::assertSentTo($specialist->users->first(), SpecialistRejectedNotification::class);
    }
}
