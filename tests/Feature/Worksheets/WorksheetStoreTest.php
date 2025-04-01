<?php

namespace Tests\Feature\Worksheets;

use App\Http\Resources\FileResource;
use App\Http\Resources\WorksheetResource;
use App\Models\User;
use App\Models\Worksheet;
use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorksheetStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_a_worksheet_and_redirects_with_success_message()
    {
        // Создаем пользователя для авторизации
        $user = User::factory()->staff()->create();

        // Создаем связанные объекты (например, файл)
        $coverFile = File::factory()
            ->withUser($user)->temp()->image()
            ->create();

        $worksheetFile = File::factory()
            ->withUser($user)->temp()->pdf()
            ->create();

        // Подготавливаем данные для запроса
        $requestData = [
            'title' => 'Test Worksheet',
            'description' => 'Test description',
            'cover' => (new FileResource($coverFile))->toArray(request()),
            'file' => (new FileResource($worksheetFile))->toArray(request())
        ];

        // Проверка, что запрос прошел успешно и редиректит на нужный маршрут
        $response = $this->actingAs($user)
            ->post(route('api.worksheets.store'), $requestData)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('worksheets.index'))
            ->assertSessionHas('success', 'Материал успешно создан');

        // Проверяем, что рабочий лист был сохранен в базе данных
        $this->assertDatabaseHas('worksheets', [
            'title' => 'Test Worksheet',
            'description' => 'Test description',
        ]);

        // Проверяем, что файлы были перемещены и прикреплены
        $coverFile->refresh();
        $this->assertEquals('public', $coverFile->storage);
        $this->assertEquals($coverFile->id, Worksheet::latest()->first()->cover_id);
        $this->assertTrue($coverFile->exists());

        $worksheetFile->refresh();
        $this->assertEquals('public', $worksheetFile->storage);
        $this->assertEquals($worksheetFile->id, Worksheet::latest()->first()->file_id);
        $this->assertTrue($worksheetFile->exists());
    }

    public function test_expects_json()
    {
        // Создаем пользователя для авторизации
        $user = User::factory()->staff()->create();

        // Создаем связанные объекты (например, файл)
        $coverFile = File::factory()
            ->withUser($user)->temp()->image()
            ->create();

        $worksheetFile = File::factory()
            ->withUser($user)->temp()->pdf()
            ->create();

        // Подготавливаем данные для запроса
        $requestData = [
            'title' => 'Test Worksheet',
            'description' => 'Test description',
            'cover' => (new FileResource($coverFile))->toArray(request()),
            'file' => (new FileResource($worksheetFile))->toArray(request())
        ];

        // Проверка, что запрос прошел успешно и редиректит на нужный маршрут
        $response = $this->actingAs($user)
            ->postJson(route('api.worksheets.store'), $requestData)
            ->assertSessionHasNoErrors()
            ->assertOk();

        $worksheet = $user->createdWorksheets()->first();

        $this->assertNotNull($worksheet);

        $worksheet->load(['creator', 'cover', 'file']);

        $response->assertJson([
            'redirect_to' => route('worksheets.show', compact('worksheet')),
            'worksheet' => (new WorksheetResource($worksheet))->toArray(request())
        ]);
    }
}
