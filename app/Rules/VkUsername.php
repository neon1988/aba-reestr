<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class VkUsername implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Проверка на соответствие формату полной ссылки ВКонтакте или только юзернейма
        if (!preg_match('/^(?:https?:\/\/(?:www\.)?vk\.com\/)?[a-zA-Z](?!.*[_.]{2})[a-zA-Z0-9_.]{3,30}[a-zA-Z0-9]$/', $value)) {
            if (!preg_match('/^[a-zA-Z](?!.*[_.]{2})[a-zA-Z0-9_.]{3,30}[a-zA-Z0-9]$/', $value)) {
                $fail('Юзернейм ВКонтакте или ссылка должны быть корректными. Юзернейм должен быть длиной от 5 до 32 символов, начинаться с латинской буквы и содержать только латинские буквы, цифры, точки или подчеркивания. Ссылка должна быть в формате https://vk.com/<юзернейм>.');
            }
        }
    }
}
