<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Webinar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WebinarSubscription>
 */
class WebinarSubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Генерируем случайного пользователя
            'webinar_id' => Webinar::factory(), // Генерируем случайный вебинар
            'subscribed_at' => $this->faker->dateTimeBetween('-1 month', 'now'), // Случайная дата подписки за последний месяц
        ];
    }
}
