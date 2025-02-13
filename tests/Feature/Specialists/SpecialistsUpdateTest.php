<?php

namespace Tests\Feature\Specialists;

use App\Enums\SubscriptionLevelEnum;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Models\Specialist;
use App\Models\Staff;
use App\Models\User;
use App\Notifications\SpecialistPendingReviewNotification;
use Carbon\Carbon;
use Database\Seeders\WorldSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SpecialistsUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateProfileMethod()
    {
        $this->seed(WorldSeeder::class);
        Storage::fake(config('filesystems.default'));

        $user = User::factory()->create([
            'subscription_level' => SubscriptionLevelEnum::B,
            'subscription_ends_at' => Carbon::now()->addYear()
        ]);

        $specialist = Specialist::factory()->make();
        $specialistArray = $specialist->toArray();
        unset($specialistArray['status']);
        unset($specialistArray['create_user_id']);

        $photo = File::factory()
            ->temp()->image()
            ->for($user, 'creator')
            ->create();

        $certificate = File::factory()
            ->temp()->pdf()
            ->for($user, 'creator')
            ->create();

        $specialistArray['photo'] =
            (new FileResource($photo))->toArray(request());

        $specialistArray['certificates'] = [
            (new FileResource($certificate))->toArray(request())
        ];

        $specialistArray['show_email'] = true;
        $specialistArray['show_phone'] = true;
        $specialistArray['has_available_hours'] = true;

        $specialist = Specialist::factory()
            ->withUser($user)
            ->create();

        $response = $this->actingAs($user)
            ->patch(route('specialists.profile.update', compact('specialist')), $specialistArray)
            ->assertSessionHasNoErrors()
            ->assertRedirect()
            ->assertSessionHas('success', 'Профиль специалиста обновлен.');

        $specialist->refresh();
        $photo->refresh();
        $certificate->refresh();

        $this->assertTrue($photo->is($specialist->photo));
        $this->assertEquals('public', $photo->storage);

        $certificates = $specialist->certificates;
        $this->assertEquals(1, $certificates->count());

        $this->assertTrue($certificate->is($certificates->first()));
        $this->assertEquals('public', $certificate->storage);
    }

    public function testUpdateMethod()
    {
        $this->seed(WorldSeeder::class);
        Storage::fake(config('filesystems.default'));

        $user = User::factory()->create([
            'subscription_level' => SubscriptionLevelEnum::B,
            'subscription_ends_at' => Carbon::now()->addYear()
        ]);

        $specialist = Specialist::factory()->make();
        $specialistArray = $specialist->toArray();
        unset($specialistArray['status']);
        unset($specialistArray['create_user_id']);

        $photo = File::factory()
            ->temp()->image()
            ->for($user, 'creator')
            ->create();

        $document = File::factory()
            ->temp()->pdf()
            ->for($user, 'creator')
            ->create();

        $additionalCourse = File::factory()
            ->temp()->pdf()
            ->for($user, 'creator')
            ->create();

        $specialistArray['photo'] =
            (new FileResource($photo))->toArray(request());

        $specialistArray['files'] = [
            (new FileResource($document))->toArray(request())
        ];

        $specialistArray['additional_courses'] = [
            (new FileResource($additionalCourse))->toArray(request())
        ];

        $specialistArray['show_email'] = true;
        $specialistArray['show_phone'] = true;
        $specialistArray['has_available_hours'] = true;

        $specialist = Specialist::factory()
            ->withUser($user)
            ->create();

        $response = $this->actingAs($user)
            ->patch(route('specialists.update', compact('specialist')), $specialistArray)
            ->assertSessionHasNoErrors()
            ->assertRedirect()
            ->assertSessionHas('success', 'Профиль специалиста обновлен.');

        $specialist->refresh();
        $photo->refresh();
        $document->refresh();
        $additionalCourse->refresh();

        $this->assertTrue($photo->is($specialist->photo));
        $this->assertEquals('public', $photo->storage);

        $documents = $specialist->files;
        $this->assertEquals(1, $documents->count());

        $this->assertTrue($document->is($documents->first()));
        $this->assertEquals('public', $document->storage);

        $additionalCourses = $specialist->additional_courses;
        $this->assertEquals(1, $additionalCourses->count());

        $this->assertTrue($additionalCourse->is($additionalCourses->first()));
        $this->assertEquals('public', $additionalCourse->storage);
    }
}
