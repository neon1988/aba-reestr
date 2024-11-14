<?php

namespace Tests\Feature\Join;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JoinControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тестирование метода join
     *
     * @return void
     */
    public function testJoinMethod()
    {
        // Создаем пользователя для аутентификации
        $user = User::factory()->create();

        // Отправляем GET-запрос к методу join, действуя от имени аутентифицированного пользователя
        $response = $this->actingAs($user)->get(route('join'));

        // Проверяем, что страница загружается с кодом 200 (успешно)
        $response->assertOk();

        // Проверяем, что в ответе содержится правильный шаблон
        $response->assertViewIs('join.join');
    }

    /**
     * Тестирование метода specialist
     *
     * @return void
     */
    public function testSpecialistMethod()
    {
        // Создаем пользователя для аутентификации
        $user = User::factory()->create();

        // Отправляем GET-запрос к методу specialist, действуя от имени аутентифицированного пользователя
        $response = $this->actingAs($user)->get(route('join.specialist'));

        // Проверяем, что страница загружается с кодом 200 (успешно)
        $response->assertOk();

        // Проверяем, что в ответе содержится правильный шаблон
        $response->assertViewIs('join.specialist');

        // Проверяем, что переменная 'countries' передана в представление
        $response->assertViewHas('countries');
    }

    /**
     * Тестирование метода center
     *
     * @return void
     */
    public function testCenterMethod()
    {
        // Создаем пользователя для аутентификации
        $user = User::factory()->create();

        // Отправляем GET-запрос к методу center, действуя от имени аутентифицированного пользователя
        $response = $this->actingAs($user)->get(route('join.center'));

        // Проверяем, что страница загружается с кодом 200 (успешно)
        $response->assertOk();

        // Проверяем, что в ответе содержится правильный шаблон
        $response->assertViewIs('join.center');

        // Проверяем, что переменная 'countries' передана в представление
        $response->assertViewHas('countries');
    }
}
