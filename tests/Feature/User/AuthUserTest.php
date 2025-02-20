<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_successful(): void
    {
        $data = [
            'name' => 'Relax',
            'email' => 'relax@test.com',
            'password' => 'password',
        ];

        $user = User::factory()->create($data);

        $response = $this->postJson(route('login'), $data);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);

    }
}
