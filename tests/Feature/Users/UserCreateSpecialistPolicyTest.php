<?php

namespace Tests\Feature\Users;

use App\Models\Specialist;
use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\SubscriptionLevelEnum;
use App\Policies\UserPolicy;

class UserCreateSpecialistPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_without_active_subscription_cannot_create_specialist()
    {
        $user = User::factory()->create([
            'subscription_ends_at' => Carbon::now()->subYear()
        ]);
        $policy = new UserPolicy();

        $response = $policy->createSpecialist($user, $user);

        $this->assertFalse($response->allowed());
        $this->assertEquals(__("You don't have a subscription or your subscription is inactive."), $response->message());
    }

    public function test_user_with_wrong_subscription_level_cannot_create_specialist()
    {
        $user = User::factory()->create([
            'subscription_ends_at' => Carbon::now()->addYear(),
            'subscription_level' => SubscriptionLevelEnum::A,
        ]);
        $policy = new UserPolicy();

        $response = $policy->createSpecialist($user, $user);

        $this->assertFalse($response->allowed());
        $this->assertEquals(__('You do not have the required subscription level.'), $response->message());
    }

    public function test_user_who_is_already_specialist_cannot_create_specialist()
    {
        $user = User::factory()->create([
            'subscription_ends_at' => Carbon::now()->addYear(),
            'subscription_level' => SubscriptionLevelEnum::B,
        ]);
        $speialist = Specialist::factory()->withUser($user)->create();

        $policy = new UserPolicy();

        $response = $policy->createSpecialist($user, $user);

        $this->assertFalse($response->allowed());
        $this->assertEquals(__('You are already a specialist.'), $response->message());
    }

    public function test_user_with_valid_subscription_can_create_specialist()
    {
        $user = User::factory()->create([
            'subscription_ends_at' => Carbon::now()->addYear(),
            'subscription_level' => SubscriptionLevelEnum::B
        ]);
        $policy = new UserPolicy();

        $response = $policy->createSpecialist($user, $user);

        $this->assertTrue($response->allowed());
        $this->assertEquals(__('You can create a new specialist.'), $response->message());
    }

    public function test_user_who_is_already_specialist_cannot_create_another_specialist()
    {
        $user = User::factory()->create([
            'subscription_ends_at' => Carbon::now()->addYear(),
            'subscription_level' => SubscriptionLevelEnum::B,
        ]);
        $speialist = Specialist::factory()->withUser($user)->create();

        $this->assertFalse($user->can('createSpecialist', $user));
    }
}
