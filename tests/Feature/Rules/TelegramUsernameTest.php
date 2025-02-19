<?php

namespace Tests\Feature\Rules;

use App\Rules\TelegramUsername;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TelegramUsernameTest extends TestCase
{
    public static function provideValidUsernames(): array
    {
        return [
            ['abcde'],           // минимальная длина, содержит 5 символов и 3 буквы
            ['abcde_123'],         // буквы, цифры и символ подчёркивания
            ['a1b2sdfsdc3'],          // чередование букв и цифр
            ['@abcde'],          // с обязательным @ в начале (опционально)
            ['@abcde_123'],        // с @ и корректным набором символов
            ['@dabcde2'],          // @ + строка из 5 символов, содержащая 3 буквы ("abc")
            ['@a1b2abcde3'],         // аналогично
            ['@Centrecorrekcia_pobedenia'],
            ['Centrecorrekcia_pobedenia']
        ];
    }

    public static function provideInvalidUsernames(): array
    {
        return [
            [''],                // пустая строка
            ['abcd'],            // менее 5 символов
            ['12345'],           // отсутствуют буквы (должно быть минимум 3 латинские буквы)
            ['_____'],           // только подчёркивания, букв нет
            ['@12345'],          // с @, но без достаточного количества букв
            ['@ab1'],            // слишком короткий даже с @
            ['abc!de'],          // содержит недопустимый символ "!"
            ['abc'],             // меньше 5 символов
            ['@abc'],            // меньше 5 символов без учёта @
            ['abc_123'],         // буквы, цифры и символ подчёркивания
            ['123abc'],          // цифры в начале, но содержит 3 буквы
            ['a1b2c3'],          // чередование букв и цифр
            ['@abc_123'],        // с @ и корректным набором символов
            ['@1abc2'],          // @ + строка из 5 символов, содержащая 3 буквы ("abc")
            ['@a1b2c3'],         // аналогично
            ['123abcde'],        // цифры в начале
        ];
    }

    #[Test]
    #[DataProvider('provideValidUsernames')]
    public function testValidUsernames(string $value): void
    {
        $rule = new TelegramUsername();
        $failCalled = false;
        $failMessage = null;

        // Функция $fail будет вызвана, если валидация не пройдет
        $fail = function ($message) use (&$failCalled, &$failMessage) {
            $failCalled = true;
            $failMessage = $message;
        };

        $rule->validate('telegram_username', $value, $fail);

        $this->assertFalse(
            $failCalled,
            "Ожидалось, что значение '$value' пройдет валидацию, но обнаружена ошибка: $failMessage"
        );
    }

    #[Test]
    #[DataProvider('provideInvalidUsernames')]
    public function testInvalidUsernames(string $value): void
    {
        $rule = new TelegramUsername();
        $failCalled = false;
        $failMessage = null;

        $fail = function ($message) use (&$failCalled, &$failMessage) {
            $failCalled = true;
            $failMessage = $message;
        };

        $rule->validate('telegram_username', $value, $fail);

        $this->assertTrue(
            $failCalled,
            "Ожидалось, что значение '$value' не пройдет валидацию, но ошибка не была вызвана."
        );
        $this->assertNotEmpty(
            $failMessage,
            "Ожидалось, что для значения '$value' будет сформировано сообщение об ошибке, но оно пустое."
        );
    }
}
