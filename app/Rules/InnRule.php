<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class InnRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Проверяем, что ИНН состоит только из цифр
        if (!ctype_digit($value)) {
            return false;
        }

        $length = strlen($value);

        // Проверяем длину ИНН
        if (!in_array($length, [10, 12])) {
            return false;
        }

        if ($length === 10) {
            return $this->validateInn10($value);
        }

        if ($length === 12) {
            return $this->validateInn12($value);
        }

        return false;
    }

    /**
     * Проверка 10-значного ИНН.
     *
     * @param string $inn
     * @return bool
     */
    private function validateInn10($inn)
    {
        $weights = [2, 4, 10, 3, 5, 9, 4, 6, 8, 0];
        $controlDigit = $this->calculateControlDigit($inn, $weights);

        return $controlDigit === (int)$inn[9];
    }

    /**
     * Расчет контрольной цифры.
     *
     * @param string $inn
     * @param array $weights
     * @return int
     */
    private function calculateControlDigit($inn, $weights)
    {
        $sum = 0;

        for ($i = 0; $i < count($weights); $i++) {
            $sum += $weights[$i] * (int)$inn[$i];
        }

        $controlDigit = $sum % 11;

        return $controlDigit > 9 ? $controlDigit % 10 : $controlDigit;
    }

    /**
     * Проверка 12-значного ИНН.
     *
     * @param string $inn
     * @return bool
     */
    private function validateInn12($inn)
    {
        $weights1 = [7, 2, 4, 10, 3, 5, 9, 4, 6, 8, 0];
        $weights2 = [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8, 0];

        $controlDigit1 = $this->calculateControlDigit(substr($inn, 0, 11), $weights1);
        $controlDigit2 = $this->calculateControlDigit($inn, $weights2);

        return $controlDigit1 === (int)$inn[10] && $controlDigit2 === (int)$inn[11];
    }

    /**
     * Сообщение об ошибке валидации.
     *
     * @return string
     */
    public function message()
    {
        return 'Поле :attribute должно быть корректным ИНН.';
    }
}
