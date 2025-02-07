<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot()
    {
        Validator::extend('phone', function ($attribute, $value, $parameters, $validator) {
            // Минимальная и максимальная длина телефона
            $minLength = $parameters[0] ?? 10;
            $maxLength = $parameters[1] ?? 15;

            // Проверка регулярного выражения и длины
            return preg_match('/^\+[0-9\s\-\(\)]+$/', $value) && strlen($value) >= $minLength && strlen($value) <= $maxLength;
        });

        // Сообщение об ошибке для кастомного правила
        Validator::replacer('phone', function ($message, $attribute, $rule, $parameters) {
            $minLength = $parameters[0] ?? 10;
            $maxLength = $parameters[1] ?? 15;

            return str_replace(
                [':attribute', ':min', ':max'],
                [$attribute, $minLength, $maxLength],
                __('validation.phone', ['attribute' => $attribute, 'min' => $minLength, 'max' => $maxLength])
            );
        });

        // Сообщение об ошибке для кастомного правила
        Validator::replacer('uppercase', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'The :attribute must be uppercase.');
        });
    }
}
