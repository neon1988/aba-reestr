<?php

namespace Tests\Feature\Specialists;

use App\Enums\SubscriptionLevelEnum;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Models\Image;
use App\Models\Specialist;
use App\Models\User;
use App\Models\Country;
use App\Notifications\SpecialistPendingReviewNotification;
use Carbon\Carbon;
use Database\Seeders\WorldSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
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

    public function testShowMethod()
    {
        $user = User::factory()->create();

        $specialist = Specialist::factory()
            ->withUser($user)
            ->create();

        $response = $this->actingAs($user)
            ->get(route('specialists.show', compact('specialist')))
            ->assertOk();
    }

    /**
     * Тестирование метода store
     *
     * @return void
     */
    public function testStoreMethod()
    {
        Notification::fake();

        $admin = User::factory()
            ->staff()
            ->create();

        $this->seed(WorldSeeder::class);
        Storage::fake(config('filesystems.default'));

        $user = User::factory()->create([
            'subscription_level' => SubscriptionLevelEnum::B,
            'subscription_ends_at' => Carbon::now()->addYear()
        ]);

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

        Notification::assertSentTo($admin, SpecialistPendingReviewNotification::class);
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
            ->create([
                'subscription_level' => SubscriptionLevelEnum::B,
                'subscription_ends_at' => Carbon::now()->addYear()
            ]);
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
