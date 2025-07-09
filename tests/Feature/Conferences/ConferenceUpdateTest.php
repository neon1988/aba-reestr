<?php

namespace Tests\Feature\Conferences;

use App\Enums\SubscriptionLevelEnum;
use App\Http\Resources\ConferenceResource;
use App\Models\File;
use App\Models\User;
use App\Models\Conference;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConferenceUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_a_conference_and_redirects_with_success_message()
    {
        // Создаем пользователя для авторизации
        $user = User::factory()->staff()->create();

        // Создаем вебинар
        $conference = Conference::factory()->create();

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
        $requestData['available_for_subscriptions'] = [SubscriptionLevelEnum::A, SubscriptionLevelEnum::C];

        // Проверка, что запрос прошел успешно и редиректит на нужный маршрут
        $response = $this->actingAs($user)
            ->patch(route('api.conferences.update', $conference), $requestData)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('conferences.index'))
            ->assertSessionHas('success', 'Мероприятие обновлено.');

        // Проверяем, что вебинар был обновлен в базе данных
        $this->assertDatabaseHas('conferences', [
            'title' => $requestData['title'],
            'description' => $requestData['description'],
        ]);

        // Проверяем, что файлы были перемещены и прикреплены
        $coverFile->refresh();
        $conference->refresh();
        $this->assertEquals('public', $coverFile->storage);
        $this->assertEquals($coverFile->id, $conference->fresh()->cover_id);
        $this->assertTrue($coverFile->exists());
        $this->assertEquals([SubscriptionLevelEnum::A, SubscriptionLevelEnum::C], $conference->available_for_subscriptions);

        $file->refresh();
        $this->assertEquals('public', $file->storage);
        $this->assertEquals($file->id, $conference->fresh()->file_id);
        $this->assertTrue($file->exists());
    }

    public function test_expects_json()
    {
        // Создаем пользователя для авторизации
        $user = User::factory()->staff()->create();

        // Создаем вебинар
        $conference = Conference::factory()->create();

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

        // Проверка, что запрос прошел успешно и возвращает JSON
        $response = $this->actingAs($user)
            ->patchJson(route('api.conferences.update', $conference), $requestData)
            ->assertOk();

        $conference->refresh();
        $conference->load(['creator', 'cover', 'file']);

        $response->assertJson([
            'redirect_to' => route('conferences.show', compact('conference')),
            'conference' => json_decode((new ConferenceResource($conference))->toJson(), true)
        ]);
    }
}
