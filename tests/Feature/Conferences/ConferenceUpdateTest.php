<?php

namespace Tests\Feature\Conferences;

use App\Enums\SubscriptionLevelEnum;
use App\Http\Resources\FileResource;
use App\Models\Conference;
use App\Models\File;
use App\Models\Specialist;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\WorldSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ConferenceUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateMethod()
    {
        Storage::fake(config('filesystems.default'));

        $admin = User::factory()->staff()->create();

        $conference = Conference::factory()
            ->create();

        $conferenceArray = Conference::factory()
            ->make()->toArray();

        unset($conferenceArray['status']);
        unset($conferenceArray['create_user_id']);

        $response = $this->actingAs($admin)
            ->patch(route('api.conferences.update', compact('conference')), $conferenceArray)
            ->assertSessionHasNoErrors()
            ->assertRedirect()
            ->assertSessionHas('success', 'Мероприятие обновлено.');

        $conference->refresh();

        //$this->assertEquals($conferenceArray, $conference->toArray());
    }
}
