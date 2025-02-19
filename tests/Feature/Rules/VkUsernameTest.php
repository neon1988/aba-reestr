<?php

namespace Tests\Feature\Rules;

use App\Rules\VkUsername;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class VkUsernameTest extends TestCase
{
    public static function provideValidUsernames(): array
    {
        return [
            ['username'],                        // простой юзернейм
            ['user_name'],                       // с подчеркиванием
            ['Username123'],                     // буквы и цифры
            ['a1234'],                           // минимальная длина (5 символов)
            ['a' . str_repeat('b', 30) . 'c'],     // максимальная длина (32 символа)
            ['https://vk.com/username'],         // полная ссылка с https
            ['http://vk.com/username'],          // полная ссылка с http
            ['https://www.vk.com/username'],     // ссылка с www
            ['https://m.vk.com/username'],     // ссылка с www
            ['11dfgsdf'],
            ['1username'],                       // не начинается с буквы
            ['user__name'],                      // два подчеркивания подряд
            ['https://vk.com/1username'],        // юзернейм начинается с цифры
            ['o___2'],
            ['s.dfgsdfgsdfg'],
            ['sdfgsdfgsdfg.sdfg'],
            ['user.bame']
        ];
    }

    public static function provideInvalidUsernames(): array
    {
        return [
            [''],                                // пустая строка
            ['abc'],                             // слишком короткий (меньше 5 символов)
            ['username_'],                       // оканчивается на символ, не являющийся буквой или цифрой
            ['username.'],                       // оканчивается на точку
            ['user..name'],                      // две точки подряд
            ['https://vk.com/'],                 // ссылка без юзернейма
            ['https://vk.com'],                  // ссылка без слеша и юзернейма
            ['http://facebook.com/username'],    // неправильный домен
            ['a' . str_repeat('b', 33) . 'c'],
            ['user.ame'],                       // с точкой
            ['112dfgsdf'],
            ['sdfgsdfgsdfgs.dfg']
        ];
    }

    #[Test]
    #[DataProvider('provideValidUsernames')]
    public function testValidUsernames(string $value): void
    {
        $rule = new VkUsername();
        $failCalled = false;
        $failMessage = null;

        $fail = function ($message) use (&$failCalled, &$failMessage) {
            $failCalled = true;
            $failMessage = $message;
        };

        $rule->validate('vk_username', $value, $fail);

        $this->assertFalse(
            $failCalled,
            "Валидация не должна выдавать ошибку для корректного значения: '{$value}'. Ошибка: {$failMessage}"
        );
    }

    #[Test]
    #[DataProvider('provideInvalidUsernames')]
    public function testInvalidUsernames(string $value): void
    {
        $rule = new VkUsername();
        $failCalled = false;
        $failMessage = null;

        $fail = function ($message) use (&$failCalled, &$failMessage) {
            $failCalled = true;
            $failMessage = $message;
        };

        $rule->validate('vk_username', $value, $fail);

        $this->assertTrue(
            $failCalled,
            "Валидация должна выдавать ошибку для некорректного значения: '{$value}'."
        );
        $this->assertNotEmpty(
            $failMessage,
            "Сообщение об ошибке не должно быть пустым для значения: '{$value}'."
        );
    }
}
