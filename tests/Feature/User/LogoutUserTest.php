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

    protected User $user;
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
    }

    public function test_successful_logout()
    {
        $response = $this->deleteJson(route('logout'));

        $response->assertStatus(200)
            ->assertJson(['message' => __('messages.logout_successfully')]);

        $this->assertCount(0, $this->user->tokens);
    }

    public function test_successful_logout_all()
    {

        $this->user->createToken('token1');
        $this->user->createToken('token2');

        $response = $this->deleteJson(route('logoutAll'));

        $response->assertStatus(200)
            ->assertJson(['message' => __('messages.successful_logout_from_all_devices')]);

        $this->assertCount(0, $this->user->tokens);
    }

}
