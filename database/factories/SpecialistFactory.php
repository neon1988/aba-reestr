<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use App\Models\Image;
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
            'lastname' => $this->faker->lastName,
            'firstname' => $this->faker->firstName,
            'middlename' => $this->faker->firstName,
            'country' => 'United Kingdom',
            'region' => $this->faker->state,
            'city' => $this->faker->city,
            'education' => $this->faker->randomElement([
                'Высшее педагогическое образование',
                'Психологическое образование',
                'Медицинское образование'
            ]),
            'phone' => $this->faker->numerify('+###########'),
            'status' => StatusEnum::Accepted,
            'create_user_id' => User::factory(),
            'photo_id' => Image::factory()
        ];
    }
}
