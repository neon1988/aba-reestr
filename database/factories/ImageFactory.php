<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Imagick;

/**
 * @extends Factory<Image>
 */
class ImageFactory extends Factory
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
        return $this->afterMaking(function (Image $image) {
            // Вызываем openImage до того как данные сохранятся в базу
            // https://i.pravatar.cc/300
            $image->openImage('https://picsum.photos/800/600?category=nature', 'url');
        });
    }
}
