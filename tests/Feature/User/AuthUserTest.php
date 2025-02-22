<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthUserTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $password;

    protected function setUp(): void
    {
        parent::setUp();

        $password = $this->password = 'password';
        $this->user = User::factory()->create(['password' => $password]);
    }

    public function test_login_successful(): void
    {
        $data = [
          'email' => $this->user->email,
          'password' => $this->password,
        ];

        $response = $this->postJson(route('login'), $data);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);

    }
}
