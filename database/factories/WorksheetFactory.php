<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Worksheet>
 */
class WorksheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence, // Название материала
            'description' => $this->faker->paragraph, // Описание материала
            'create_user_id' => User::factory(), // Используем фабрику для создания пользователя
            'cover_id' => File::factory()->image(), // Используем фабрику для создания обложки
            'file_id' => File::factory()->state([
                'storage' => 'private',
            ])->randomType(['pdf', 'video']), // Используем фабрику для создания файла материала
            'price' => $this->faker->randomNumber(1) * 200,
        ];
    }

    /**
     * Устанавливает файл записи вебинара, если передан внешний файл.
     *
     * @param null $file
     * @return Factory
     */
    public function withFile($file = null): Factory
    {
        return $this->state(function () use ($file) {
            return [
                'file_id' => $file,
            ];
        });
    }
}
