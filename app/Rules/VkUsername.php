<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class VkUsername implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Определяем, является ли значение ссылкой (начинается с http:// или https://)
        $isUrl = preg_match('/^https?:\/\//i', $value) === 1;

        if ($isUrl) {
            // Разбираем URL
            $parsedUrl = parse_url($value);
            if ($parsedUrl === false || !isset($parsedUrl['host'])) {
                $fail('Ссылка имеет некорректный формат.');
                return;
            }

            // Проверяем, что домен принадлежит vk.com (возможно, с субдоменом)
            $host = $parsedUrl['host'];
            if (!preg_match('/^(?:[a-zA-Z0-9_.]+\.)?vk\.com$/', $host)) {
                $fail('Ссылка должна принадлежать домену vk.com.');
                return;
            }

            // Проверяем, что в URL есть путь с юзернеймом
            if (!isset($parsedUrl['path']) || trim($parsedUrl['path'], '/') === '') {
                $fail('Ссылка должна содержать юзернейм после домена.');
                return;
            }
            $username = trim($parsedUrl['path'], '/');
        } else {
            // Если это не ссылка, считаем, что введено просто значение юзернейма
            $username = $value;
        }

        // Выполняем проверку юзернейма
        $this->validateUsername($username, $fail);
    }

    protected function validateUsername(string $username, Closure $fail): void
    {
        // 1. Проверка длины: от 5 до 32 символов
        $length = mb_strlen($username);
        if ($length < 5 || $length > 32) {
            $fail('Юзернейм должен быть длиной от 5 до 32 символов.');
            return;
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

        // 2. Проверка, что не начинается с трёх и более цифр
        if (preg_match('/^\d{3,}/', $username)) {
            $fail('Юзернейм не должен начинаться с трёх и более цифр.');
            return;
        }

        // 4. Проверка, что не содержит точку с менее чем четырьмя знаками после
        if (preg_match('/\.[a-zA-Z0-9]{0,3}$/', $username)) {
            $fail('Юзернейм не должен содержать точку, после которой расположено менее четырёх знаков, начинающихся с буквы.');
            return;
        }

        // 5. Проверка отсутствия двойных точек
        if (preg_match('/\.\./', $username)) {
            $fail('Юзернейм не должен содержать двойные точки.');
            return;
        }

        // 6. Проверка допустимых символов: только латинские буквы и цифры
        if (!preg_match('/^[a-zA-Z0-9_\.]+$/', $username)) {
            $fail('Юзернейм может содержать только латинские буквы и цифры.');
            return;
        }
    }
}
