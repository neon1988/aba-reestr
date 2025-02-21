<?php

namespace Feature\Specialists;

use App\Enums\SubscriptionLevelEnum;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Models\Specialist;
use App\Models\Staff;
use App\Models\User;
use App\Notifications\SpecialistPendingReviewNotification;
use Carbon\Carbon;
use Database\Seeders\WorldSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SpecialistsShowTest extends TestCase
{
    use RefreshDatabase;

    public function testShowMethod()
    {
        $user = User::factory()->create();

        $specialist = Specialist::factory()
            ->withUser($user)
            ->create();

        $response = $this->actingAs($user)
            ->get(route('specialists.show', compact('specialist')))
            ->assertOk();
    }

    public function test_not_found()
    {
        $user = User::factory()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('specialists.show', 1))
            ->assertNotFound();
    }
}
