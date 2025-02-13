<?php

namespace Tests\Feature\Specialists;

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

class SpecialistEditTest extends TestCase
{
    use RefreshDatabase;

    public function testShowMethod()
    {
        $user = User::factory()->create();

        $specialist = Specialist::factory()
            ->withUser($user)
            ->create();

        $response = $this->actingAs($user)
            ->get(route('specialists.edit', compact('specialist')))
            ->assertOk();
    }
}
