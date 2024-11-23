<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;
use Imagick;
use ImagickPixel;

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
            if (App::environment('testing')) {
                $imagick = new Imagick();
                $imagick->newImage(300, 300, new ImagickPixel('red')); // 300x300 пикселей, красный фон
                $imagick->setImageFormat('jpeg');
                $image->openImage($imagick, 'jpeg', true);
            } else {
                // Вызываем openImage до того как данные сохранятся в базу
                // https://i.pravatar.cc/300
                $image->openImage('https://picsum.photos/800/600?category=nature', 'url');
            }
        });
    }
}
