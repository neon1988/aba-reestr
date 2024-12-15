<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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

    public function configure()
    {
        return $this->afterMaking(function (File $file) {
            $file->open((string)realpath(__DIR__).'/files/sample.mp4');
            $file->name = 'sample.mp4';
        });
    }
}
