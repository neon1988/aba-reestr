<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class InnRule implements Rule
{
    /**
     * Проверяет корректность ИНН.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Проверяем, что значение состоит только из цифр
        if (!preg_match('/^\d{10}|\d{12}$/', $value)) {
            return false;
        }

        $length = strlen($value);

        if ($length === 10) {
            // Проверка для юридических лиц (10 цифр)
            return $this->validateChecksum($value, [2, 4, 10, 3, 5, 9, 4, 6, 8]);
        } elseif ($length === 12) {
            // Проверка для физических лиц (12 цифр)
            $isValidFirstChecksum = $this->validateChecksum($value, [7, 2, 4, 10, 3, 5, 9, 4, 6, 8], 10);
            $isValidSecondChecksum = $this->validateChecksum($value, [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8], 11);
            return $isValidFirstChecksum && $isValidSecondChecksum;
        }

        return false;
    }

    /**
     * Возвращает сообщение об ошибке.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.inn');
    }

    /**
     * Проверяет корректность контрольной суммы.
     *
     * @param  string  $value
     * @param  array  $weights
     * @param  int|null  $position
     * @return bool
     */
    protected function validateChecksum($value, $weights, $position = null)
    {
        $position = $position ?? (count($weights) - 1);
        $sum = 0;

        foreach ($weights as $index => $weight) {
            $sum += $value[$index] * $weight;
        }

        $controlDigit = $sum % 11;
        if ($controlDigit > 9) {
            $controlDigit %= 10;
        }

        return $controlDigit === (int) $value[$position];
    }
}
