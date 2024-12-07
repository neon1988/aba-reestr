<?php

namespace Tests\Feature\Centers;

use App\Models\Center;
use App\Models\User;
use Database\Seeders\WorldSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Imagick;
use ImagickPixel;
use Tests\TestCase;

class CentersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тестирование метода index
     *
     * @return void
     */
    public function testIndexMethod()
    {
        // Создаем пользователя для аутентификации
        $user = User::factory()->create();

        // Создаем несколько центров
        Center::factory()->count(5)->create();

        // Отправляем GET-запрос к методу index, действуя от имени аутентифицированного пользователя
        $response = $this->actingAs($user)->get(route('centers.index'));

        // Проверяем, что страница загружается с кодом 200 (успешно)
        $response->assertOk();

        // Проверяем, что в ответе содержится правильный шаблон
        $response->assertViewIs('centers.index');

        // Проверяем, что в представлении передан список центров
        $response->assertViewHas('centers');
    }

    /**
     * Тестирование метода store
     *
     * @return void
     */
    public function testStoreMethod()
    {
        $this->seed(WorldSeeder::class);

        // Создаем пользователя для аутентификации
        $user = User::factory()->create();

        $center = Center::factory()->make();
        $centerArray = $center->toArray();
        unset($centerArray['status']);
        unset($centerArray['create_user_id']);

        Storage::fake('public');

        $filePath = 'fake/file.txt';

        $imagick = new Imagick();
        $imagick->newImage(500, 500, new ImagickPixel('red')); // 300x300 пикселей, красный фон
        $imagick->addNoiseImage(Imagick::NOISE_GAUSSIAN);
        $imagick->setImageFormat('jpeg');

        Storage::disk('public')
            ->put($filePath, $imagick->getImageBlob());

        $centerArray['photo'] = [
            $filePath
        ];

        $centerArray['files'] = [
            $filePath
        ];

        // Отправляем POST-запрос для создания нового центра
        $response = $this->actingAs($user)
            ->post(route('centers.store'), $centerArray)
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $center = $user->centers()->first();

        $this->assertNotNull($center);

        // Проверяем, что произошел редирект на страницу нового центра
        $response->assertRedirect(route('centers.show', ['center' => $center->id]));

        // Проверяем, что в сессии присутствует сообщение об успешном добавлении
        $response->assertSessionHas('success', 'Центр успешно добавлен!');

        $this->assertTrue($center->isSentForReview());

        $photo = $user->photo()->first();
        $this->assertNotNull($photo);
        $this->assertEquals('images', $photo->dirname);

        $file = $center->files()->first();
        $this->assertNotNull($file);
        $this->assertEquals('files', $file->dirname);
    }
}
