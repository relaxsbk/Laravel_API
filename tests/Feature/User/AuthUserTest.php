<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthUserTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $data = [
            'name' => 'Relax',
            'email' => 'relax@test.com',
            'password' => 'password',
        ];

        $this->user = User::factory()->create($data);
    }

    public function test_login_successful(): void
    {
        $data = [
          'email' => $this->user->email,
          'password' => $this->user->password,
        ];

        $response = $this->postJson(route('login'), $data);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);

    }
}
