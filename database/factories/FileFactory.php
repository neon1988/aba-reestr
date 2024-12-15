<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'create_user_id' => User::factory()
        ];
    }

    /**
     * Состояние для видеофайла.
     */
    public function video(): Factory
    {
        return $this->afterMaking(function (File $file) {
            $file->open((string)realpath(__DIR__).'/files/sample.mp4');
            $file->name = 'sample.mp4';
        });
    }

    /**
     * Состояние для PDF-файла.
     */
    public function pdf(): Factory
    {
        return $this->afterMaking(function (File $file) {
            $file->open((string)realpath(__DIR__).'/files/sample.pdf');
            $file->name = 'sample.pdf';
        });
    }

    /**
     * Случайный выбор между video и pdf.
     */
    public function randomType(): Factory
    {
        $states = ['video', 'pdf'];

        // Выбираем случайное состояние
        $state = Arr::random($states);

        return $this->{$state}(); // Вызов соответствующего состояния
    }

    public function configure()
    {
        $states = ['video', 'pdf'];

        // Выбираем случайное состояние
        $state = Arr::random($states);

        return $this->{$state}(); // Вызов соответствующего состояния
    }
}
