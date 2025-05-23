<?php

namespace Database\Factories;

use App\Enums\EducationEnum;
use App\Enums\StatusEnum;
use App\Models\File;
use App\Models\Image;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Specialist>
 */
class SpecialistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'middlename' => $this->faker->firstName,
            'country' => 'United Kingdom',
            'region' => $this->faker->state,
            'city' => $this->faker->city,
            'education' => EducationEnum::getRandomValue(),
            'phone' => $this->faker->numerify('+###########'),
            'status' => StatusEnum::Accepted,
            'create_user_id' => User::factory(),
            'photo_id' => File::factory()->image(),
            'center_name' => $this->faker->company
        ];
    }

    public function withUser(User $user = null)
    {
        return $this->afterCreating(function (Specialist $specialist) use ($user) {
            $specialist->users()->attach($user ?? User::factory()->create());
        });
    }
}
