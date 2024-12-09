<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TelegramUsername implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^@?(?=(?:[0-9_]*[a-z]){3})[a-z0-9_]{5,}$/', $value))
            $fail('Юзернейм должен содержать не менее 5 символов, начинаться с @ (опционально), включать как минимум 3 латинские'.
                ' буквы и состоять только из латинских букв, цифр или подчеркивания.');
    }
}
