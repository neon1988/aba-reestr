<?php

namespace Tests\Feature\Resources;

use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class FileResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_file_resource_transforms_correctly()
    {
        $file = File::factory()->create();

        // Создаем ресурс
        $resource = new FileResource($file); // Передаем массив вместо stdClass

        // Преобразуем в массив
        $array = $resource->toArray(new Request());

        // Проверяем, что данные корректно преобразуются
        $this->assertEquals($file->url, $array['url']);
        $this->assertEquals($file->path, $array['path']);
    }

    public function test_file_not_existed()
    {
        // Создаем ресурс
        $resource = new FileResource(['id' => null]); // Передаем массив вместо stdClass

        // Преобразуем в массив
        $array = $resource->toArray(new Request());

        $this->assertEquals([], $array);
    }
}
