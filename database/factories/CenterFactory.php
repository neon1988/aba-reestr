<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Center>
 */
class CenterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,                     // Название компании
            'legal_name' => $this->faker->companySuffix . ' ' . $this->faker->company, // Юридическое название
            'inn' => $this->faker->unique()->numerify('##########'), // ИНН (10 цифр для примера)
            'kpp' => $this->faker->optional()->numerify('#########'), // КПП (9 цифр, может быть пустым)
            'country' => 'United Kingdom',                   // Страна
            'region' => $this->faker->state,                      // Регион
            'city' => $this->faker->city,                         // Город
            'phone' => $this->faker->phoneNumber,                 // Телефон
            'status' => StatusEnum::Accepted,
            'create_user_id' => User::factory(),
        ];
    }
}
