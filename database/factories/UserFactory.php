<?php

namespace Database\Factories;

use App\Enums\SubscriptionLevelEnum;
use App\Models\File;
use App\Models\Image;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'lastname' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => $this->faker->numerify('+###########'),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'photo_id' => null,
            'subscription_level' => SubscriptionLevelEnum::getRandomValue(),
            'subscription_ends_at' => $this->faker->dateTimeBetween('now', '+12 month'),
        ];
    }

    // ➤ Состояние для успешного платежа
    public function withoutSubscription()
    {
        return $this->state(fn (array $attributes) => [
            'subscription_level' => SubscriptionLevelEnum::Free,
            'subscription_ends_at' => null
        ]);
    }

    public function withInactiveSubscription($subscriptionLevel)
    {
        return $this->state(fn (array $attributes) => [
            'subscription_level' => $subscriptionLevel,
            'subscription_ends_at' => Carbon::now()->subMinutes(1),
        ]);
    }

    public function withActiveSubscription($subscriptionLevel = SubscriptionLevelEnum::A)
    {
        return $this->state(fn (array $attributes) => [
            'subscription_level' => $subscriptionLevel,
            'subscription_ends_at' => Carbon::now()->addMonths(12),
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function staff(): static
    {
        return $this->state(function (array $attributes) {
            return [];
        })->afterCreating(function (User $user) {
            $user->staffs()->createMany(Staff::factory(1)->admin()->make()->toArray());
        });
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            if (rand(0, 1))
            {
                $image = File::factory()
                    ->randomType(['image'])
                    ->create(['create_user_id' => $user->id]);

                $user->photo_id = $image->id;
                $user->save();
            }
        });
    }

    public function withStaff(Staff $staff = null)
    {
        return $this->afterCreating(function (User $user) use ($staff) {
            $user->staffs()->attach($staff ?? Staff::factory()->create());
        });
    }

    public function withPhoto(File $file = null)
    {
        return $this->afterCreating(function (User $user) use ($file) {
            $user->photo_id = $file->id;
            $user->push();
        });
    }
}
