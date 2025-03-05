<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use App\Models\File;
use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conference>
 */
class ConferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(3),
            'start_at' => $this->faker->dateTimeBetween('now', '+1 year'),
            'end_at' => $this->faker->dateTimeBetween('+1 year', '+2 years'),
            'cover_id' => File::factory()->image(),
            'created_at' => now(),
            'updated_at' => now(),
            'create_user_id' => User::factory(),
            'price' => $this->faker->randomNumber(1) * 200,
        ];
    }

    /**
     * Indicate that the conference has ended.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function ended(): Factory
    {
        return $this->state(function (array $attributes) {
            $startAt = $this->faker->dateTimeBetween('-2 years', '-1 year');
            $endAt = (clone $startAt)->modify('+8 hours');  // Устанавливаем end_at как 8 часов после start_at

            return [
                'start_at' => $startAt,
                'end_at' => $endAt,
                'file_id' => File::factory()->state([
                    'storage' => 'private',
                ])->randomType(['video'])
            ];
        });
    }

    public function withFile($file = null): Factory
    {
        return $this->state(function () use ($file) {
            return [
                'file_id' => $file,
            ];
        });
    }
}
