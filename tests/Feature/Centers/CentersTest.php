<?php

namespace Tests\Feature\Centers;

use App\Models\Center;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CentersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Тестирование метода index
     *
     * @return void
     */
    public function testIndexMethod()
    {
        // Создаем пользователя для аутентификации
        $user = User::factory()->create();

        // Создаем несколько центров
        Center::factory()->count(5)->create();

        // Отправляем GET-запрос к методу index, действуя от имени аутентифицированного пользователя
        $response = $this->actingAs($user)->get(route('centers.index'));

        // Проверяем, что страница загружается с кодом 200 (успешно)
        $response->assertOk();

        // Проверяем, что в ответе содержится правильный шаблон
        $response->assertViewIs('centers.index_in_dev');

        // Проверяем, что в представлении передан список центров
        // $response->assertViewHas('centers');
    }
}
