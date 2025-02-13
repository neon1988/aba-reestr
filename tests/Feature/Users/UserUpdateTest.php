<?php

namespace Tests\Feature\Users;

use App\Enums\SubscriptionLevelEnum;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateUser()
    {
        $user = User::factory()->staff()->create();

        $data = [
            'name' => 'Updated Name',
            'lastname' => 'Updated Lastname',
            'middlename' => 'Updated Middlename',
            'subscription_level' => SubscriptionLevelEnum::getRandomValue(),
            'subscription_ends_at' => Carbon::createFromTime(1, 1, 1),
        ];

        $photo = File::factory()
            ->temp()->image()
            ->for($user, 'creator')
            ->create();

        $data['photo'] =
            (new FileResource($photo))->toArray(request());

        $this->actingAs($user)
            ->patchJson(route('users.update', $user), $data)
            ->assertSessionHasNoErrors()
            ->assertOk()
            ->assertJsonFragment(['message' => 'Данные пользователя сохранены']);

        $user->refresh();

        $this->assertEquals($data['name'], $user->name);
        $this->assertEquals($data['lastname'], $user->lastname);
        $this->assertEquals($data['middlename'], $user->middlename);
        $this->assertEquals($data['subscription_level'], $user->subscription_level);
        $this->assertEquals($data['subscription_ends_at'], $user->subscription_ends_at);
    }
}
