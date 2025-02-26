<?php

namespace Tests\Feature\Conferences;

use App\Enums\SubscriptionLevelEnum;
use App\Models\Conference;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConferenceDownloadTest extends TestCase
{
    use RefreshDatabase;

    public function test_download_conference()
    {
        $user = User::factory()
            ->create([
                'subscription_level' => SubscriptionLevelEnum::A,
                'subscription_ends_at' => Carbon::now()->addYear()
            ]);;

        $conference = Conference::factory()
            ->ended()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('conferences.download', $conference))
            ->assertOk();

        $this->assertEquals('application/x-force-download', $response->headers->get('content-type'));
        $this->assertEquals('attachment; filename="'.$conference->file->name.'"', $response->headers->get('content-disposition'));
        $this->assertStringContainsString($conference->file->dirname.'/'.$conference->file->name, $response->headers->get('x-accel-redirect'));
    }
}
