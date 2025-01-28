<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class VkUsername implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Проверка на соответствие формату юзернейма ВКонтакте
        if (!preg_match('/^[a-zA-Z](?!.*[_.]{2})[a-zA-Z0-9_.]{3,30}[a-zA-Z0-9]$/', $value)) {
            $fail('Юзернейм ВКонтакте должен быть длиной от 5 до 32 символов, начинаться с латинской буквы и содержать только латинские буквы, цифры, точки или подчеркивания.');
        }
    }
}
