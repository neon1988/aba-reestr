<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BankAccountRule implements ValidationRule
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
        // Проверяем, что расчетный счет состоит из 20 цифр
        if (!preg_match('/^\d{20}$/', $value)) {
            $fail(__('Поле :attribute должно содержать 20 цифр.', ['attribute' => $attribute]));
            return;
        }

        // Дополнительная проверка контрольного разряда
        if (!$this->validateChecksum($value)) {
            $fail(__('Поле :attribute содержит некорректный номер расчетного счета.', ['attribute' => $attribute]));
        }
    }

    /**
     * Validate checksum for the bank account number.
     *
     * @param string $accountNumber
     * @return bool
     */
    private function validateChecksum(string $accountNumber): bool
    {
        // Алгоритм проверки контрольного разряда (пример для РФ)
        // Подставьте нужный алгоритм или используйте банковские стандарты
        $weights = [7, 1, 3]; // Пример весов
        $checksum = 0;

        for ($i = 0; $i < strlen($accountNumber); $i++) {
            $checksum += $accountNumber[$i] * $weights[$i % count($weights)];
        }

        return $checksum % 10 === 0;
    }
}
