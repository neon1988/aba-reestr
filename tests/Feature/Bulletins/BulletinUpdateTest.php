<?php

namespace Tests\Feature\Bulletins;

use App\Enums\StatusEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BulletinUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_user_can_create_bulletin()
    {
        $user = User::factory()->create();

        $data = [
            'text' => 'Test Bulletin',
        ];

        $response = $this->actingAs($user)
            ->post(route('bulletins.store'), $data)
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success', 'Объявление успешно добавлено')
            ->assertRedirect(route('bulletins.index'));

        $this->assertDatabaseHas('bulletins', [
            'text' => $data['text'],
            'status' => StatusEnum::OnReview,
            'create_user_id' => $user->id,
        ]);
    }
}
