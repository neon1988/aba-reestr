<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TelegramUsername implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = mb_strtolower($value);
        // Если юзернейм начинается с "@", удаляем его для дальнейших проверок
        $username = ltrim($value, '@');

        // Проверка, что начинается с латинской буквы
        if (!preg_match('/^[A-Za-z]/', $username)) {
            $fail('Юзернейм должен начинаться с латинской буквы.');
        }

        // Проверка, что не начинается с подчеркивания
        if (preg_match('/^_/u', $username)) {
            $fail('Юзернейм не должен начинаться с подчеркивания.');
            return;
        }

        // Проверка, что не начинается с подчеркивания
        if (preg_match('/_$/u', $username)) {
            $fail('Юзернейм не должен заканчиваться подчеркиванием.');
            return;
        }

        // 1. Проверка минимальной длины (не менее 5 символов)
        if (mb_strlen($username) < 5) {
            $fail('Юзернейм должен содержать не менее 5 символов.');
        }

        // 2. Проверка допустимых символов (только латинские буквы, цифры и подчеркивание)
        if (!preg_match('/^[A-Za-z0-9_]+$/', $username)) {
            $fail('Юзернейм может состоять только из латинских букв, цифр или подчеркивания.');
        }

        // 3. Проверка наличия хотя бы 5 латинских букв.
        // Используем preg_match_all для подсчета букв
        if (preg_match_all('/[A-Za-z]/', $username) < 5) {
            $fail('Юзернейм должен включать как минимум 5 латинских букв.');
        }
    }
}
