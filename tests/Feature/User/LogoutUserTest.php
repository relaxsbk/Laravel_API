<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_logout()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson(route('logout'));

        $response->assertStatus(200)
            ->assertJson(['message' => __('messages.logout_successfully')]);

        $this->assertCount(0, $user->tokens);
    }

    public function test_successful_logout_all()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->createToken('token1');
        $user->createToken('token2');

        $response = $this->postJson(route('logoutAll'));

        $response->assertStatus(200)
            ->assertJson(['message' => __('messages.successful_logout_from_all_devices')]);

        $this->assertCount(0, $user->tokens);
    }

}
