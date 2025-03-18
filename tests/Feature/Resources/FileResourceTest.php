<?php

namespace Tests\Feature\Resources;

use App\Http\Resources\FileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class FileResourceTest extends TestCase
{
    public function test_file_resource_transforms_correctly()
    {
        // Подделываем хранилище
        Storage::fake('public');

        // Данные файла в виде массива
        $fileData = [
            'id' => 42,
            'storage' => 'public',
            'dirname' => 'uploads',
            'name' => 'test.jpg',
        ];

        // Создаем ресурс
        $resource = new FileResource($fileData); // Передаем массив вместо stdClass

        // Преобразуем в массив
        $array = $resource->toArray(new Request());

        // Ожидаемый URL
        $expectedUrl = Storage::disk('public')->url('uploads/test.jpg');
        $expectedPath = URL::to('uploads/test.jpg');

        // Проверяем, что данные корректно преобразуются
        $this->assertEquals('/storage/uploads/test.jpg', $array['url']);
        $this->assertEquals('uploads/test.jpg', $array['path']);
    }

    public function test_file_resource_transforms_correctly_without_storage()
    {
        // Подделываем хранилище
        Storage::fake('public');

        // Данные файла в виде массива
        $fileData = [
            'id' => 42,
            'dirname' => 'uploads',
            'name' => 'test.jpg',
        ];

        // Создаем ресурс
        $resource = new FileResource($fileData); // Передаем массив вместо stdClass

        // Преобразуем в массив
        $array = $resource->toArray(new Request());

        // Проверяем, что данные корректно преобразуются
        $this->assertEquals('uploads', $array['dirname']);
        $this->assertEquals('test.jpg', $array['name']);
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
