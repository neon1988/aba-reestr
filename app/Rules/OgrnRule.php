<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OgrnRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Проверяем, что ОГРН состоит из 13 цифр
        if (!preg_match('/^\d{13}$/', $value)) {
            $fail(__('Поле :attribute должно содержать 13 цифр.', ['attribute' => $attribute]));
            return;
        }

        // Проверяем контрольное число
        $baseNumber = substr($value, 0, -1);
        $controlNumber = (int)substr($value, -1);
        $calculatedControl = (int)$baseNumber % 11 % 10;

        if ($calculatedControl !== $controlNumber) {
            $fail(__('Поле :attribute содержит некорректное контрольное число.', ['attribute' => $attribute]));
        }
    }
}
