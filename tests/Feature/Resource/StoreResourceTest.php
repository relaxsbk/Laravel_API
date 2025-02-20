<?php

namespace Tests\Feature\Resource;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StoreResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($this->user);
    }

    public function test_store_resource(): void
    {
        $data = [
            'name' => fake()->name,
            'type' => fake()->jobTitle(),
            'description' => fake()->text(),
            'available' => true
        ];

        $response = $this->postJson(route('resources.store'), $data);
        $response->assertCreated();

        $response->assertJsonStructure([
            'id', 'name', 'type', 'description', 'available'
        ]);

        $response->assertJson([
            'name' => Arr::get($data, 'name'),
            'type' => Arr::get($data, 'type'),
            'description' => Arr::get($data, 'description'),
            'available' => Arr::get($data, 'available'),
        ]);

        $this->assertDatabaseHas('resources', [
            'id' => $response->json('id'),
            'name' => Arr::get($data, 'name'),
            'type' => Arr::get($data, 'type'),
            'description' => Arr::get($data, 'description'),
            'available' => Arr::get($data, 'available'),
        ]);
    }

    public function test_store_resource_validation_fails()
    {
        $data = [
            'name' => null,
            'type' => null,
            'description' => 23,
        ];
        $response = $this->postJson(route('resources.store'), $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'type', 'description']);
    }
}
