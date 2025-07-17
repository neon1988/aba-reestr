<?php

namespace Tests\Feature\Worksheets;

use App\Enums\PaymentProvider;
use App\Models\File;
use App\Models\Payment;
use App\Models\User;
use App\Models\Worksheet;
use App\Policies\WorksheetPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorksheetWatchPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_denies_if_not_video_file()
    {
        $user = User::factory()->create();
        $file = File::factory()->pdf()->create();
        $worksheet = Worksheet::factory()->withFile($file)->create();

        $response = (new WorksheetPolicy)->watch($user, $worksheet);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("You can only watch it if the file is a video file."), $response->message());
    }

    public function test_allows_for_staff_even_if_paid()
    {
        $user = User::factory()->staff()->create();
        $file = File::factory()->video()->create();
        $worksheet = Worksheet::factory()->paid()->withFile($file)->create();

        $response = (new WorksheetPolicy)->watch($user, $worksheet);
        $this->assertTrue($response->allowed());
    }

    public function test_denies_if_paid_and_not_purchased_and_no_subscription()
    {
        $user = User::factory()->withoutSubscription()->create();
        $file = File::factory()->video()->create();
        $worksheet = Worksheet::factory()->paid()->withFile($file)->create();

        $response = (new WorksheetPolicy)->watch($user, $worksheet);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("You don't have a subscription or your subscription is inactive."), $response->message());
    }

    public function test_allows_if_paid_and_purchased_by_user()
    {
        $user = User::factory()->withoutSubscription()->create();
        $file = File::factory()->video()->create();
        $worksheet = Worksheet::factory()->paid()->withFile($file)->create();

        Payment::factory()
            ->forUser($user)
            ->withPurchase($worksheet)
            ->succeeded()
            ->create([
                'payment_provider' => PaymentProvider::RoboKassa
            ]);

        $response = (new WorksheetPolicy)->watch($user, $worksheet);
        $this->assertTrue($response->allowed());
    }

    public function test_allows_if_paid_and_has_active_subscription()
    {
        $user = User::factory()->withActiveSubscription()->create();
        $file = File::factory()->video()->create();
        $worksheet = Worksheet::factory()->paid()->withFile($file)->create();

        $response = (new WorksheetPolicy)->watch($user, $worksheet);
        $this->assertTrue($response->allowed());
    }

    public function test_allows_for_free_video_worksheet()
    {
        $user = User::factory()->create();
        $file = File::factory()->video()->create();
        $worksheet = Worksheet::factory()->free()->withFile($file)->create();

        $response = (new WorksheetPolicy)->watch($user, $worksheet);
        $this->assertTrue($response->allowed());
    }
}
