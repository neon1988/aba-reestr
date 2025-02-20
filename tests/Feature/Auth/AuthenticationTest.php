<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'remember' => '0'
        ])->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->assertAuthenticated();
    }

    public function test_remember_me(): void
    {
        $user = User::factory()
            ->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'remember' => '1'
        ])->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->assertAuthenticated();
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertSessionHasErrors()
            ->assertRedirect();

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    public function test_intended(): void
    {
        $user = User::factory()
            ->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        session(['url.intended' => $verificationUrl]);

        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertStatus(201);

        $this->assertAuthenticated();

        $response->assertJson([
                'message' => __('Login successful.'),
                'redirect_to' => $verificationUrl
            ]);
    }
}
