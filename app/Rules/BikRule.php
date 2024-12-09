<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Closure;

class BikRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Проверяем, что БИК состоит из 9 цифр
        if (!preg_match('/^\d{9}$/', $value)) {
            $fail(__('Поле :attribute должно содержать 9 цифр.', ['attribute' => $attribute]));
            return;
        }

        // Проверяем, что первые 2 цифры находятся в допустимом диапазоне (01-99)
        $regionCode = substr($value, 0, 2);
        if ((int)$regionCode < 1 || (int)$regionCode > 99) {
            $fail(__('Поле :attribute имеет некорректный код региона.', ['attribute' => $attribute]));
        }
    }
}
