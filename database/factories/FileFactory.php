<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Imagick;
use ImagickPixel;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    use RandomImageGenerator;
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
     * Состояние для PDF-файла.
     */
    public function image(): Factory
    {
        return $this->afterMaking(function (File $file) {
            if (App::environment('testing')) {
                $imagick = new Imagick();
                $imagick->newImage(500, 500, new ImagickPixel('red')); // 300x300 пикселей, красный фон
                $imagick->addNoiseImage(Imagick::NOISE_GAUSSIAN);
                $imagick->setImageFormat('jpeg');
                $imageBlob = $imagick->getImageBlob();
                $stream = fopen('php://memory', 'r+');
                fwrite($stream, $imageBlob);
                rewind($stream);

                $file->open($stream, 'jpeg');
            } else {
                // Вызываем openImage до того как данные сохранятся в базу
                // https://i.pravatar.cc/300
                $imageBlob = $this->generateRandomImage(640, 480)->getImageBlob();
                $stream = fopen('php://memory', 'r+');
                fwrite($stream, $imageBlob);
                rewind($stream);

                $file->open($stream, 'jpeg');
            }

            $file->name = uniqid().'.jpg';
        });
    }

    /**
     * Случайный выбор между video и pdf.
     */
    public function randomType(array | null $states): Factory
    {
        if (!is_array($states)) {
            $states = ['video', 'pdf', 'image'];
        }

        // Выбираем случайное состояние
        $state = Arr::random($states);

        return $this->{$state}(); // Вызов соответствующего состояния
    }

    public function configure()
    {
        $states = ['video', 'pdf', 'image'];

        // Выбираем случайное состояние
        $state = Arr::random($states);

        return $this->{$state}(); // Вызов соответствующего состояния
    }
}
