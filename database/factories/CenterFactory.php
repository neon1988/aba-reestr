<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use App\Models\Image;
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
            'inn' =>  generateValidInn($this->faker), // ИНН (10 цифр для примера)
            'kpp' => $this->faker->optional()->numerify('#########'), // КПП (9 цифр, может быть пустым)
            'country' => 'United Kingdom',                   // Страна
            'region' => $this->faker->state,                      // Регион
            'city' => $this->faker->city,                         // Город
            'phone' => $this->faker->numerify('+###########'),                 // Телефон
            'status' => StatusEnum::Accepted,
            'create_user_id' => User::factory(),
            'photo_id' => Image::factory()
        ];
    }
}


/**
 * Генерирует валидный ИНН (10 или 12 цифр) с учетом контрольных сумм
 *
 * @return string
 */
function generateValidInn($faker)
{
    // Определяем длину ИНН: 10 (юридические лица) или 12 (физические лица)
    $length = $faker->randomElement([10, 12]);

    // Генерируем базовые цифры ИНН (на 1 или 2 меньше общей длины)
    $inn = '';
    for ($i = 0; $i < ($length === 10 ? 9 : 10); $i++) {
        $inn .= $faker->randomDigit();
    }

    // Добавляем контрольные цифры
    if ($length === 10) {
        // 10-значный ИНН
        $weights = [2, 4, 10, 3, 5, 9, 4, 6, 8];
        $inn .= generateControlDigit($inn, $weights, 9);
    } else {
        // 12-значный ИНН
        $weights1 = [7, 2, 4, 10, 3, 5, 9, 4, 6, 8];
        $weights2 = [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8];
        $inn .= generateControlDigit($inn, $weights1, 10);
        $inn .= generateControlDigit($inn, $weights2, 11);
    }

    return $inn;
}



/**
 * Генерирует контрольную цифру для ИНН
 *
 * @param string $inn
 * @param array $weights
 * @param int $position
 * @return int
 */
function generateControlDigit($inn, $weights, $position)
{
    $sum = 0;

    // Убедитесь, что длина $inn совпадает с количеством весов, которые используются
    for ($i = 0; $i < count($weights); $i++) {
        $sum += $inn[$i] * $weights[$i];
    }

    $controlDigit = $sum % 11;
    if ($controlDigit > 9) {
        $controlDigit %= 10;
    }

    return $controlDigit;
}


