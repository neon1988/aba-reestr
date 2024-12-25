<?php

namespace Tests\Feature\Specialists;

use App\Http\Resources\FileResource;
use App\Models\File;
use App\Models\Image;
use App\Models\Specialist;
use App\Models\User;
use App\Models\Country;
use Database\Seeders\WorldSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Imagick;
use ImagickPixel;
use Tests\TestCase;

class SpecialistsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тестирование метода index
     *
     * @return void
     */
    public function testIndexMethod()
    {
        $user = User::factory()->create();

        $specialists = Specialist::factory()
            ->count(3)
            ->create();

        $response = $this->actingAs($user)
            ->get(route('specialists.index'))
            ->assertOk()
            ->assertViewIs('specialists.index')
            ->assertViewHas('specialists');
    }

    /**
     * Тестирование метода store
     *
     * @return void
     */
    public function testStoreMethod()
    {
        $this->seed(WorldSeeder::class);
        Storage::fake(config('filesystems.default'));

        $user = User::factory()->create();

        $lastname = uniqid();

        $specialist = Specialist::factory()->make(['lastname' => $lastname]);
        $specialistArray = $specialist->toArray();
        unset($specialistArray['status']);
        unset($specialistArray['create_user_id']);

        $photo = File::factory()
            ->temp()->image()
            ->for($user, 'creator')
            ->create();

        $file = File::factory()
            ->temp()->pdf()
            ->for($user, 'creator')
            ->create();

        $specialistArray['photo'] =
            (new FileResource($photo))->toArray(request());

        $specialistArray['files'] = [
            (new FileResource($file))->toArray(request())
        ];

        $specialistArray['additional_courses'] = [
            (new FileResource($photo))->toArray(request())
        ];

        $specialistArray['confirm_document_authenticity'] = true;

        // Отправляем POST-запрос с данными для создания специалиста
        $response = $this->actingAs($user)
            ->post(route('specialists.store'), $specialistArray)
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $specialist = $user->specialists()->first();

        $this->assertNotNull($specialist);

        // Проверяем, что после сохранения происходит редирект на страницу специалиста
        $specialist = Specialist::where('lastname', $lastname)->first();
        $response->assertRedirect(route('specialists.show', $specialist));

        // Проверяем, что в сессии есть сообщение об успешном добавлении
        $response->assertSessionHas('success', 'Специалист успешно добавлен!');

        $photo = $user->photo()->first();
        $this->assertNotNull($photo);

        $photo = $specialist->photo()->first();
        $this->assertNotNull($photo);

        $file = $specialist->files()->first();
        $this->assertNotNull($file);
    }

    /**
     * Тестирование метода store
     *
     * @return void
     */
    public function testStoreMethodPhotoFromUser()
    {
        $this->seed(WorldSeeder::class);
        Storage::fake(config('filesystems.default'));

        $photo = File::factory()
            ->temp()->image()
            ->create();

        $user = User::factory()
            ->create();
        $user->photo_id = $photo->id;
        $user->save();
        $user->refresh();

        $lastname = uniqid();

        $specialist = Specialist::factory()->make(['lastname' => $lastname]);
        $specialistArray = $specialist->toArray();
        unset($specialistArray['status']);
        unset($specialistArray['create_user_id']);

        Storage::fake('public');

        $file = File::factory()
            ->temp()->pdf()
            ->for($user, 'creator')
            ->create();

        $specialistArray['files'] = [
            (new FileResource($file))->toArray(request())
        ];

        $specialistArray['additional_courses'] = [
            (new FileResource($photo))->toArray(request())
        ];

        $specialistArray['confirm_document_authenticity'] = true;

        // Отправляем POST-запрос с данными для создания специалиста
        $response = $this->actingAs($user)
            ->post(route('specialists.store'), $specialistArray)
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $specialist = $user->specialists()->first();

        $this->assertNotNull($specialist);

        // Проверяем, что после сохранения происходит редирект на страницу специалиста
        $specialist = Specialist::where('lastname', $lastname)->first();
        $response->assertRedirect(route('specialists.show', $specialist));

        // Проверяем, что в сессии есть сообщение об успешном добавлении
        $response->assertSessionHas('success', 'Специалист успешно добавлен!');

        $photo = $user->photo()->first();
        $this->assertNotNull($photo);

        $photo = $specialist->photo()->first();
        $this->assertNotNull($photo);

        $this->assertEquals($user->photo()->first()->id, $specialist->photo()->first()->id);

        $file = $specialist->files()->first();
        $this->assertNotNull($file);
    }
}
