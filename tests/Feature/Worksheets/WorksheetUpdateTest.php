<?php

namespace Tests\Feature\Worksheets;

use App\Http\Resources\FileResource;
use App\Http\Resources\WorksheetResource;
use App\Models\User;
use App\Models\Worksheet;
use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorksheetUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_a_worksheet_and_redirects_with_success_message()
    {
        // Создаем пользователя для авторизации
        $user = User::factory()->staff()->create();

        // Создаем рабочий лист
        $worksheet = Worksheet::factory()
            ->withTags(4)
            ->create();

        // Создаем связанные файлы
        $coverFile = File::factory()
            ->withUser($user)->temp()->image()
            ->create();

        $worksheetFile = File::factory()
            ->withUser($user)->temp()->pdf()
            ->create();

        $this->assertEquals(4, $worksheet->tags->count());

        // Подготавливаем данные для запроса
        $requestData = [
            'title' => 'Updated Test Worksheet',
            'description' => 'Updated description',
            'cover' => (new FileResource($coverFile))->toArray(request()),
            'file' => (new FileResource($worksheetFile))->toArray(request()),
            'tags' => ['tag1', 'tag2'],
            'price' => null
        ];

        // Проверка, что запрос прошел успешно и редиректит на нужный маршрут
        $response = $this->actingAs($user)
            ->patch(route('api.worksheets.update', $worksheet), $requestData)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('worksheets.index'))
            ->assertSessionHas('success', 'Материал успешно обновлен');

        // Проверяем, что рабочий лист был обновлен в базе данных
        $this->assertDatabaseHas('worksheets', [
            'title' => 'Updated Test Worksheet',
            'description' => 'Updated description',
        ]);

        // Проверяем, что файлы были перемещены и прикреплены
        $coverFile->refresh();
        $worksheet->refresh();
        $this->assertEquals(0, $worksheet->price);
        $this->assertEquals('public', $coverFile->storage);
        $this->assertEquals($coverFile->id, $worksheet->cover_id);
        $this->assertTrue($coverFile->exists());

        $worksheetFile->refresh();
        $this->assertEquals('public', $worksheetFile->storage);
        $this->assertEquals($worksheetFile->id, $worksheet->file_id);
        $this->assertTrue($worksheetFile->exists());

        $tags = $worksheet->tags()->get();

        $this->assertEquals(2, $tags->count());
        $this->assertEquals(['tag1', 'tag2'], $tags->pluck('name')->toArray());
    }

    public function test_expects_json()
    {
        // Создаем пользователя для авторизации
        $user = User::factory()->staff()->create();

        // Создаем рабочий лист
        $worksheet = Worksheet::factory()->create();

        // Создаем связанные файлы
        $coverFile = File::factory()
            ->withUser($user)->temp()->image()
            ->create();

        $worksheetFile = File::factory()
            ->withUser($user)->temp()->pdf()
            ->create();

        // Подготавливаем данные для запроса
        $requestData = [
            'title' => 'Updated Test Worksheet',
            'description' => 'Updated description',
            'cover' => (new FileResource($coverFile))->toArray(request()),
            'file' => (new FileResource($worksheetFile))->toArray(request()),
            'price' => '420'
        ];

        // Проверка, что запрос прошел успешно и редиректит на нужный маршрут
        $response = $this->actingAs($user)
            ->patchJson(route('api.worksheets.update', $worksheet), $requestData)
            ->assertSessionHasNoErrors()
            ->assertOk();

        $worksheet->refresh();
        $worksheet->load(['creator', 'cover', 'file']);

        $this->assertEquals(420, $worksheet->price);
        $response->assertJson([
            'redirect_to' => route('worksheets.show', compact('worksheet')),
            'worksheet' => json_decode((new WorksheetResource($worksheet))->toJson(), true)
        ]);
    }
}
