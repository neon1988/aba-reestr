<?php
namespace Database\Factories;

use App\Enums\StatusEnum;
use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Center>
 */
class CenterFactory extends Factory
{
    /**
     * Определение базового состояния фабрики.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'legal_name' => $this->faker->companySuffix . ' ' . $this->faker->company,
            'inn' => boolval(rand(0, 1)) ? generateINNFL() : generateINNUL(),
            'kpp' => $this->faker->optional()->numerify('#########'),
            'country' => 'United Kingdom',
            'region' => $this->faker->state,
            'city' => $this->faker->city,
            'phone' => $this->faker->numerify('+###########'),
            'status' => StatusEnum::Accepted,
            'create_user_id' => User::factory(),
            'photo_id' => Image::factory(),
        ];
    }
}



