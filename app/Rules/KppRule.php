<?php

// app/Rules/KppValidation.php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class KppRule implements Rule
{
    /**
     * Определяет, применимо ли правило к атрибуту.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Проверка формата КПП: 9 символов (цифры и латинские буквы для 5 и 6 знаков)
        return preg_match('/^\d{4}[A-Z0-9]{2}\d{3}$/', $value);
    }

    /**
     * Получить сообщение об ошибке.
     *
     * @param string $attribute
     * @return string
     */
    public function message()
    {
        return 'Поле :attribute должно быть валидным КПП, состоящим из 9 символов (цифры и латинские буквы для 5 и 6 знаков).';
    }
}
