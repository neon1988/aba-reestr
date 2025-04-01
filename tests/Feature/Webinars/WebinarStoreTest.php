<?php

namespace Tests\Feature\Webinars;

use App\Http\Resources\WebinarResource;
use App\Models\User;
use App\Models\Webinar;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebinarStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_a_webinar_and_redirects_with_success_message()
    {
        // Создаем пользователя для авторизации
        $user = User::factory()->staff()->create();

        // Создаем связанные объекты (например, файл)
        $coverFile = File::factory()
            ->withUser($user)->temp()->image()
            ->create();

        $requestData = Webinar::factory()->create()->fresh()->toArray();
        $requestData['cover'] = $coverFile->toArray();

        // Проверка, что запрос прошел успешно и редиректит на нужный маршрут
        $response = $this->actingAs($user)
            ->post(route('api.webinars.store'), $requestData)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('webinars.index'))
            ->assertSessionHas('success', 'Вебинар успешно добавлен');

        $webinar = $user->createdWebinars()->first();

        // Проверяем, что вебинар был сохранен в базе данных
        $this->assertDatabaseHas('webinars', [
            'title' => $requestData['title'],
            'description' => $requestData['description'],
        ]);

        // Проверяем, что файл был перемещен и прикреплен
        $coverFile->refresh();
        $this->assertEquals('public', $coverFile->storage);
        $this->assertNotNull($webinar->cover);
        $this->assertTrue($coverFile->exists());
    }

    public function test_expects_json()
    {
        // Создаем пользователя для авторизации
        $user = User::factory()->staff()->create();

        // Создаем связанные объекты (например, файл)
        $coverFile = File::factory()
            ->withUser($user)->temp()->image()
            ->create();

        $requestData = Webinar::factory()->create()->fresh()->toArray();
        $requestData['cover'] = $coverFile->toArray();

        // Проверка, что запрос прошел успешно и возвращает JSON
        $response = $this->actingAs($user)
            ->postJson(route('api.webinars.store'), $requestData)
            ->assertOk();

        $webinar = $user->createdWebinars()->first();

        $this->assertNotNull($webinar);

        $webinar->load(['creator', 'cover']);

        $response->assertJson([
            'redirect_to' => route('webinars.show', compact('webinar')),
            'webinar' => (new WebinarResource($webinar))->toArray(request())
        ]);
    }
}
