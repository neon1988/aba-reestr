<?php

namespace Tests\Feature\Specialists;

use App\Models\Specialist;
use App\Models\User;
use App\Models\Country;
use Database\Seeders\WorldSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

        // Проверяем, что на странице есть список специалистов
        $response->assertSee($specialists[0]->lastname);
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

        $specialistArray['photo'] = UploadedFile::fake()->image('test-image.jpg', 500, 500);
        $specialistArray['file'] = UploadedFile::fake()->image('test-image2.jpg', 500, 500);

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

        $photo = $specialist->photo()->first();
        $this->assertNotNull($photo);

        $file = $specialist->files()->first();
        $this->assertNotNull($file);
    }
}
