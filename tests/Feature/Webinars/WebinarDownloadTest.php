<?php

namespace Feature\Webinars;

use App\Enums\SubscriptionLevelEnum;
use App\Models\User;
use App\Models\Webinar;
use App\Models\Worksheet;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebinarDownloadTest extends TestCase
{
    use RefreshDatabase;

    public function test_download_worksheet()
    {
        $user = User::factory()
            ->create([
                'subscription_level' => SubscriptionLevelEnum::A,
                'subscription_ends_at' => Carbon::now()->addYear()
            ]);;

        $webinar = Webinar::factory()
            ->ended()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('webinars.download', $webinar))
            ->assertOk();

        $this->assertEquals('application/x-force-download', $response->headers->get('content-type'));
        $this->assertEquals('attachment; filename="'.$webinar->record_file->name.'"', $response->headers->get('content-disposition'));
        $this->assertStringContainsString($webinar->record_file->dirname.'/'.$webinar->record_file->name, $response->headers->get('x-accel-redirect'));
    }
}
