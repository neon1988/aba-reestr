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
            'registration_url' => $this->faker->url(),
            'cover_id' => File::factory()->image(),
            'created_at' => now(),
            'updated_at' => now(),
            'create_user_id' => User::factory(),
            'price' => $this->faker->randomNumber(1) * 200,
            'url_button_text' => $this->faker->sentence(2)
        ];
    }

    public function paid($price = 42): Factory
    {
        return $this->state(function (array $attributes) use ($price) {
            return [
                'price' => $price
            ];
        });
    }

    public function free(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'price' => 0
            ];
        });
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

    public function withRequiredLevel($level = null): Factory
    {
        return $this->state(function () use($level) {
            return [
                'available_for_subscriptions' => [$level],
            ];
        });
    }

    public function withoutRecord(): Factory
    {
        return $this->state(function () {
            return [
                'file_id' => null
            ];
        });
    }
}
