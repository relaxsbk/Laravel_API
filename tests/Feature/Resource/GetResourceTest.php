<?php

namespace Tests\Feature\Resource;

use App\Models\Resource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetResourceTest extends TestCase
{
    use RefreshDatabase;

    protected Resource $resource;

    protected Resource $draftResource;

    protected function setUp(): void
    {
        parent::setUp();

        $this->resource = Resource::factory()->createOne(['available' => true]);

        $this->draftResource = Resource::factory()->createOne(['available' => false]);


    }

    public function test_get_resource(): void
    {
        $response = $this->get(route('resources.show', $this->resource->id));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'id', 'name', 'type', 'description', 'available', 'createdAt'
        ]);

        $response->assertJson([
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'type' => $this->resource->type,
            'description' => $this->resource->description,
            'available' => $this->resource->available,
            'createdAt' => $this->resource->createdAt(),
        ]);
    }

    public function test_draft_resource(): void
    {
        $response = $this->get(route('resources.show', $this->draftResource->id));

        $response->assertNotFound();
        $response->assertJsonStructure(['message']);
        $response->assertJson(['message' => __('messages.resource_not_found')]);

    }

    public function test_not_found_resource(): void
    {
        $response = $this->get(route(' resources.show', ['resource' => 0]));

        $response->assertNotFound();
        $response->assertJsonStructure(['message']);
        $response->assertJson(['message' => __('messages.model_not_found')]);
    }
}
