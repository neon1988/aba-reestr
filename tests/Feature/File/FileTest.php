<?php

namespace Tests\Feature\File;

use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_upload_valid_image()
    {
        Storage::fake('temp');

        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('photo.jpg', 600, 600);

        $response = $this->actingAs($user)
            ->postJson(route('files.store'), [
            'file' => $file,
        ]);

        $response->assertStatus(201); // Или 200, в зависимости от контроллера

        // Проверяем, что файл действительно сохранён
        Storage::disk('temp')->assertExists('files');

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'storage',
                'url',
                'size',
                // другие поля, если есть
            ]
        ]);

        $file = File::first();

        $this->assertNotNull($file);
    }

    public function test_upload_fails_if_file_missing()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('files.store'));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['file']);
    }

    public function test_guest_cannot_upload_files()
    {
        $file = UploadedFile::fake()->image('image.png');

        $response = $this->postJson(route('files.store'), [
            'file' => $file,
        ]);

        $response->assertStatus(401); // Unauthorized
    }
}
