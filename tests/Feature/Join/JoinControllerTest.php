<?php

namespace Join;

use App\Models\Country;
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
        // Отправляем GET-запрос к методу join
        $response = $this->get(route('join.join'));

        // Проверяем, что страница загружается с кодом 200 (успешно)
        $response->assertStatus(200);

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
        // Создаем несколько стран для теста
        Country::factory()->count(3)->create();

        // Отправляем GET-запрос к методу specialist
        $response = $this->get(route('join.specialist'));

        // Проверяем, что страница загружается с кодом 200 (успешно)
        $response->assertStatus(200);

        // Проверяем, что в ответе содержится правильный шаблон
        $response->assertViewIs('join.specialist');

        // Проверяем, что переменная 'countries' передана в представление
        $response->assertViewHas('countries');

        // Проверяем, что количество стран в представлении совпадает с количеством созданных
        $this->assertCount(3, $response->viewData('countries'));
    }

    /**
     * Тестирование метода center
     *
     * @return void
     */
    public function testCenterMethod()
    {
        // Создаем несколько стран для теста
        Country::factory()->count(3)->create();

        // Отправляем GET-запрос к методу center
        $response = $this->get(route('join.center'));

        // Проверяем, что страница загружается с кодом 200 (успешно)
        $response->assertStatus(200);

        // Проверяем, что в ответе содержится правильный шаблон
        $response->assertViewIs('join.center');

        // Проверяем, что переменная 'countries' передана в представление
        $response->assertViewHas('countries');

        // Проверяем, что количество стран в представлении совпадает с количеством созданных
        $this->assertCount(3, $response->viewData('countries'));
    }
}
