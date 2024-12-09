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
            'ogrn' => $this->faker->numerify('##############'),
            'legal_address' => $this->faker->address,
            'actual_address' => $this->faker->address,
            'profile_address_1' => $this->faker->optional()->address,
            'profile_address_2' => $this->faker->optional()->address,
            'profile_address_3' => $this->faker->optional()->address,
            'account_number' => $this->faker->numerify('####################'),
            'bik' => $this->faker->numerify('########'),
            'director_position' => $this->faker->jobTitle,
            'director_name' => $this->faker->name,
            'acting_on_basis' => $this->faker->randomElement(['Устава', 'Доверенности', 'Контракта']),
            'profile_phone' => $this->faker->numerify('+###########'),
            'profile_email' => $this->faker->safeEmail,
            'status' => StatusEnum::Accepted,
            'create_user_id' => User::factory(),
            'photo_id' => Image::factory(),
        ];
    }

}



