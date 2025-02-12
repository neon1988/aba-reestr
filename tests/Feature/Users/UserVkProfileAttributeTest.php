<?php

namespace Tests\Feature\Users;

use App\Models\Specialist;
use Tests\TestCase;

class UserVkProfileAttributeTest extends TestCase
{
    // Проверка, если строка — это URL vk.com
    public function testSetVkProfileUrl()
    {
        $user = new Specialist();

        // Пример ссылки на профиль
        $url = 'https://vk.com/annavolkova_aba';
        $user->vk_profile = $url;

        // Проверяем, что из URL извлекается правильное имя пользователя
        $this->assertEquals('annavolkova_aba', $user->vk_profile);
    }

    // Проверка, если строка содержит @ в начале
    public function testSetVkProfileWithAtSymbol()
    {
        $user = new Specialist();

        // Пример имени пользователя с @
        $value = '@annavolkova_aba';
        $user->vk_profile = $value;

        // Проверяем, что @ удаляется
        $this->assertEquals('annavolkova_aba', $user->vk_profile);
    }

    // Проверка, если строка не является ни ссылкой, ни именем пользователя
    public function testSetVkProfileEmpty()
    {
        $user = new Specialist();

        // Пример пустого значения
        $value = '';
        $user->vk_profile = $value;

        // Проверяем, что возвращается null
        $this->assertNull($user->vk_profile);
    }

    // Проверка, если строка не является ссылкой vk.com, но имеет другой URL
    public function testSetVkProfileInvalidUrl()
    {
        $user = new Specialist();

        // Пример некорректного URL
        $url = 'https://google.com/someprofile';
        $user->vk_profile = $url;

        // Проверяем, что возвращается исходное значение URL, так как это не vk.com
        $this->assertEquals('https://google.com/someprofile', $user->vk_profile);
    }

    // Проверка, если строка не содержит символа @, но является правильным именем
    public function testSetVkProfileWithoutAtSymbol()
    {
        $user = new Specialist();

        // Пример имени пользователя без @
        $value = 'annavolkova_aba';
        $user->vk_profile = $value;

        // Проверяем, что возвращается имя пользователя без изменений
        $this->assertEquals('annavolkova_aba', $user->vk_profile);
    }
}
