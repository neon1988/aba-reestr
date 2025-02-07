<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneRule implements Rule
{
    /**
     * Минимальная длина телефона
     *
     * @var int
     */
    protected $minLength;

    /**
     * Максимальная длина телефона
     *
     * @var int
     */
    protected $maxLength;

    /**
     * Создает новый экземпляр правила валидации телефона.
     *
     * @param int $minLength
     * @param int $maxLength
     */
    public function __construct($minLength = 10, $maxLength = 15)
    {
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }

    /**
     * Определяет, проходит ли значение валидацию.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Проверка по регулярному выражению и длине
        return preg_match('/^\+[0-9\s\-\(\)]+$/', $value) &&
            strlen($value) >= $this->minLength &&
            strlen($value) <= $this->maxLength;
    }

    /**
     * Получить сообщение об ошибке для этого правила.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.phone', [
            'min' => $this->minLength,
            'max' => $this->maxLength,
        ]);
    }
}
