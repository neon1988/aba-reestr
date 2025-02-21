<?php

namespace Feature\Worksheets;

use App\Enums\SubscriptionLevelEnum;
use App\Models\User;
use App\Models\Worksheet;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorksheetDownloadTest extends TestCase
{
    use RefreshDatabase;

    public function test_download_worksheet()
    {
        $user = User::factory()
            ->create([
                'subscription_level' => SubscriptionLevelEnum::A,
                'subscription_ends_at' => Carbon::now()->addYear()
            ]);;

        $worksheet = Worksheet::factory()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('worksheets.download', $worksheet))
            ->assertOk();

        $this->assertEquals('application/x-force-download', $response->headers->get('content-type'));
        $this->assertEquals('attachment; filename="'.$worksheet->file->name.'"', $response->headers->get('content-disposition'));
        $this->assertStringContainsString($worksheet->file->dirname.'/'.$worksheet->file->name, $response->headers->get('x-accel-redirect'));
    }
}
