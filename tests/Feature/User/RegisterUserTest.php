<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_register(): void
    {
        $data = [
            'name' => fake()->name,
            'email' => fake()->email,
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
            'name' => Arr::get($data, 'name'),
            'email' => Arr::get($data, 'email'),

        ]);

    }
    public function test_registration_validation_fails()
    {
        $response = $this->postJson(route('register'), []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }
}
