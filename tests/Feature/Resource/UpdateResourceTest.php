<?php

namespace Tests\Feature\Resource;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateResourceTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Resource $resource;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($this->user);

        $this->resource = Resource::factory()->create();
    }

    public function test_update_resource(): void
    {
        $data = [
            'name' => fake()->name,
            'type' => fake()->jobTitle(),
            'description' => fake()->text(),
        ];

        $response = $this->patchJson(route('resources.update', $this->resource->id), $data);
        $response->assertSuccessful();

        $response->assertJsonStructure([
            'id', 'name', 'type', 'description', 'available'
        ]);
        $response->assertJson([
            'id' => $this->resource->id,
            'name' => Arr::get($data, 'name'),
            'type' => Arr::get($data, 'type'),
            'description' => Arr::get($data, 'description'),
            'available' => $this->resource->available,
        ]);

        $this->assertDatabaseHas('resources', [
            'id' => $this->resource->id,
            'name' => Arr::get($data, 'name'),
            'type' => Arr::get($data, 'type'),
            'description' => Arr::get($data, 'description'),
            'available' => $this->resource->available,
        ]);
    }

    public function test_update_one_field_resource(): void
    {
        $data = [
            'name' => fake()->name,
        ];

        $response = $this->patchJson(route('resources.update', $this->resource->id), $data);
        $response->assertSuccessful();

        $response->assertJsonStructure([
            'id', 'name', 'type', 'description', 'available'
        ]);
        $response->assertJson([
            'id' => $this->resource->id,
            'name' => Arr::get($data, 'name'),
            'type' => $this->resource->type,
            'description' => $this->resource->description,
            'available' => $this->resource->available,
        ]);

        $this->assertDatabaseHas('resources', [
            'id' => $this->resource->id,
            'name' => Arr::get($data, 'name'),
            'type' => $this->resource->type,
            'description' => $this->resource->description,
            'available' => $this->resource->available,
        ]);
    }

}
