<?php

namespace Tests\Feature\Conferences;

use App\Http\Resources\ConferenceResource;
use App\Models\File;
use App\Models\User;
use App\Models\Conference;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConferenceStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_a_conference_and_redirects_with_success_message()
    {
        // Создаем пользователя для авторизации
        $user = User::factory()->staff()->create();

        // Создаем связанные объекты (например, файл)
        $coverFile = File::factory()
            ->withUser($user)->temp()->image()
            ->create();

        $file = File::factory()
            ->withUser($user)->temp()->pdf()
            ->create();

        $requestData = Conference::factory()->create()->fresh()->toArray();
        $requestData['cover'] = $coverFile->toArray();
        $requestData['file'] = $file->toArray();

        // Проверка, что запрос прошел успешно и редиректит на нужный маршрут
        $response = $this->actingAs($user)
            ->post(route('api.conferences.store'), $requestData)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('conferences.index'))
            ->assertSessionHas('success', 'Мероприятие успешно добавлено');

        $conference = $user->createdConferences()->first();

        // Проверяем, что вебинар был сохранен в базе данных
        $this->assertDatabaseHas('conferences', [
            'title' => $requestData['title'],
            'description' => $requestData['description'],
        ]);

        // Проверяем, что файл был перемещен и прикреплен
        $coverFile->refresh();
        $this->assertEquals('public', $coverFile->storage);
        $this->assertNotNull($conference->cover);
        $this->assertTrue($coverFile->exists());

        $file->refresh();
        $this->assertEquals('public', $file->storage);
        $this->assertTrue($file->exists());
    }

    public function test_expects_json()
    {
        // Создаем пользователя для авторизации
        $user = User::factory()->staff()->create();

        // Создаем связанные объекты (например, файл)
        $coverFile = File::factory()
            ->withUser($user)->temp()->image()
            ->create();

        $requestData = Conference::factory()->create()->fresh()->toArray();
        $requestData['cover'] = $coverFile->toArray();

        // Проверка, что запрос прошел успешно и возвращает JSON
        $response = $this->actingAs($user)
            ->postJson(route('api.conferences.store'), $requestData)
            ->assertOk();

        $conference = $user->createdConferences()->first();

        $this->assertNotNull($conference);

        $conference->load(['creator', 'cover']);

        $response->assertJson([
            'redirect_to' => route('conferences.show', compact('conference')),
            'conference' => json_decode((new ConferenceResource($conference))->toJson(), true)
        ]);
    }
}
