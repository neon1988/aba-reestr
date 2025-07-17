<?php

namespace Tests\Feature\Webinars;

use App\Http\Resources\WebinarResource;
use App\Models\User;
use App\Models\Webinar;
use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebinarUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_a_webinar_and_redirects_with_success_message()
    {
        // Создаем пользователя для авторизации
        $user = User::factory()->staff()->create();

        // Создаем вебинар
        $webinar = Webinar::factory()->create();

        // Создаем связанные объекты (например, файл)
        $coverFile = File::factory()
            ->withUser($user)->temp()->image()
            ->create();

        $recordFile = File::factory()
            ->withUser($user)->temp()->pdf()
            ->create();

        $requestData = Webinar::factory()->create()->fresh()->toArray();
        $requestData['cover'] = $coverFile->toArray();
        $requestData['record_file'] = $recordFile->toArray();

        // Проверка, что запрос прошел успешно и редиректит на нужный маршрут
        $response = $this->actingAs($user)
            ->patch(route('api.webinars.update', $webinar), $requestData)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('webinars.index'))
            ->assertSessionHas('success', 'Вебинар успешно обновлен');

        // Проверяем, что вебинар был обновлен в базе данных
        $this->assertDatabaseHas('webinars', [
            'title' => $requestData['title'],
            'description' => $requestData['description'],
        ]);

        // Проверяем, что файлы были перемещены и прикреплены
        $coverFile->refresh();
        $this->assertEquals('public', $coverFile->storage);
        $this->assertEquals($coverFile->id, $webinar->fresh()->cover_id);
        $this->assertTrue($coverFile->exists());

        $recordFile->refresh();
        $this->assertEquals('public', $recordFile->storage);
        $this->assertEquals($recordFile->id, $webinar->fresh()->record_file_id);
        $this->assertTrue($recordFile->exists());
    }

    public function test_expects_json()
    {
        // Создаем пользователя для авторизации
        $user = User::factory()->staff()->create();

        // Создаем вебинар
        $webinar = Webinar::factory()->create();

        // Создаем связанные объекты (например, файл)
        $coverFile = File::factory()
            ->withUser($user)->temp()->image()
            ->create();

        $recordFile = File::factory()
            ->withUser($user)->temp()->pdf()
            ->create();

        $requestData = Webinar::factory()->create()->fresh()->toArray();
        $requestData['cover'] = $coverFile->toArray();
        $requestData['record_file'] = $recordFile->toArray();

        // Проверка, что запрос прошел успешно и возвращает JSON
        $response = $this->actingAs($user)
            ->patchJson(route('api.webinars.update', $webinar), $requestData)
            ->assertOk();

        $webinar->refresh();
        $webinar->load(['creator', 'cover', 'record_file']);

        $response->assertJson([
            'redirect_to' => route('webinars.show', compact('webinar')),
            'webinar' => json_decode((new WebinarResource($webinar))->toJson(), true)
        ]);
    }

    public function test_empty_price()
    {
        // Создаем пользователя для авторизации
        $user = User::factory()->staff()->create();

        // Создаем вебинар
        $webinar = Webinar::factory()->create();

        // Создаем связанные объекты (например, файл)
        $coverFile = File::factory()
            ->withUser($user)->temp()->image()
            ->create();

        $recordFile = File::factory()
            ->withUser($user)->temp()->pdf()
            ->create();

        $requestData = Webinar::factory()->create()->fresh()->toArray();
        $requestData['cover'] = $coverFile->toArray();
        $requestData['record_file'] = $recordFile->toArray();
        $requestData['price'] = 0;

        // Проверка, что запрос прошел успешно и возвращает JSON
        $response = $this->actingAs($user)
            ->patchJson(route('api.webinars.update', $webinar), $requestData)
            ->assertOk();

        $webinar->refresh();
        $webinar->load(['creator', 'cover', 'record_file']);

        $this->assertDatabaseHas('webinars', [
            'title' => $requestData['title'],
            'description' => $requestData['description'],
            'price' => 0
        ]);
    }
}
