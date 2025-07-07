<?php

namespace Tests\Feature\Auth;

use Anhskohbo\NoCaptcha\Facades\NoCaptcha;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        NoCaptcha::shouldReceive('verifyResponse')
            ->once()
            ->andReturn(true);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'lastname' => 'Lastname',
            'email' => 'test@ya.ru',
            'password' => 'password',
            'password_confirmation' => 'password',
            'accept_private_policy' => 'true',
            'accept_offer' => 'true',
            'g-recaptcha-response' => '1'
        ])->assertSessionHasNoErrors();

        $this->assertAuthenticated();
        $response->assertRedirect(route('join', absolute: false));
    }
}
