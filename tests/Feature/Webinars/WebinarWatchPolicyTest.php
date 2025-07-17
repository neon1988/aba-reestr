<?php

namespace Tests\Feature\Webinars;

use App\Models\File;
use App\Models\User;
use App\Models\Webinar;
use App\Models\Payment;
use App\Enums\PaymentProvider;
use App\Policies\WebinarPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebinarWatchPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_denies_if_no_record_file()
    {
        $user = User::factory()->create();
        $webinar = Webinar::factory()->paid()->withoutRecord()->create();

        $response = (new WebinarPolicy)->watch($user, $webinar);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("The webinar has no record."), $response->message());
    }

    public function test_denies_if_file_is_not_video()
    {
        $user = User::factory()->create();
        $file = File::factory()->pdf()->create();
        $webinar = Webinar::factory()->paid()->withFile($file)->create();

        $response = (new WebinarPolicy)->watch($user, $webinar);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("You can only watch it if the file is a video file."), $response->message());
    }

    public function test_allows_for_staff_even_if_paid()
    {
        $user = User::factory()->staff()->create();
        $file = File::factory()->video()->create();
        $webinar = Webinar::factory()->paid()->withFile($file)->create();

        $response = (new WebinarPolicy)->watch($user, $webinar);
        $this->assertTrue($response->allowed());
    }

    public function test_denies_if_paid_and_no_subscription_and_not_purchased()
    {
        $user = User::factory()->withoutSubscription()->create();
        $file = File::factory()->video()->create();
        $webinar = Webinar::factory()->paid()->withFile($file)->create();

        $response = (new WebinarPolicy)->watch($user, $webinar);
        $this->assertFalse($response->allowed());
        $this->assertEquals(__("You don't have a subscription or your subscription is inactive."), $response->message());
    }

    public function test_allows_if_paid_and_purchased_by_user()
    {
        $user = User::factory()->withoutSubscription()->create();
        $file = File::factory()->video()->create();
        $webinar = Webinar::factory()->paid()->withFile($file)->create();

        Payment::factory()
            ->forUser($user)
            ->withPurchase($webinar)
            ->succeeded()
            ->create([
                'payment_provider' => PaymentProvider::RoboKassa,
            ]);

        $response = (new WebinarPolicy)->watch($user, $webinar);
        $this->assertTrue($response->allowed());
    }

    public function test_allows_if_paid_and_subscription_active()
    {
        $user = User::factory()->withActiveSubscription()->create();
        $file = File::factory()->video()->create();
        $webinar = Webinar::factory()->paid()->withFile($file)->create();

        $response = (new WebinarPolicy)->watch($user, $webinar);
        $this->assertTrue($response->allowed());
    }

    public function test_allows_for_free_webinar_with_record()
    {
        $user = User::factory()->create();
        $file = File::factory()->video()->create();
        $webinar = Webinar::factory()->free()->withFile($file)->create();

        $response = (new WebinarPolicy)->watch($user, $webinar);
        $this->assertTrue($response->allowed());
    }
}
