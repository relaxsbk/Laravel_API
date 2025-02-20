<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_register(): void
    {
        $data = [
            'name' => 'Relax',
            'email' => 'relax@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson(route('register'), $data);
        $response->assertCreated();

        $response->assertJsonStructure(['message']);
        $response->assertJson([
            'message' => __('messages.user_registered_successfully')
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

    }
    public function test_registration_validation_fails()
    {
        $response = $this->postJson(route('register'), []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }
}
