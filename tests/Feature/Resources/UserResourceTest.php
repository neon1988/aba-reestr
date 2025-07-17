<?php

namespace Tests\Feature\Resources;

use App\Http\Resources\FileResource;
use App\Http\Resources\UserResource;
use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_resource_transforms_correctly()
    {
        $file = File::factory()->image()->create();

        $user = User::factory()->withPhoto($file)->create()->fresh();
        $user->load('photo');

        // Создаем ресурс
        $resource = new UserResource($user); // Передаем массив вместо stdClass

        // Преобразуем в массив
        $array = $resource->toArray(new Request());

        // Проверяем, что данные корректно преобразуются
        $this->assertEquals($user->name, $array['name']);
        $this->assertEquals($user->lastname, $array['lastname']);

        $this->assertEquals($file->url, $array['photo']['url']);
        $this->assertEquals($file->path, $array['photo']['path']);
    }
}
