<?php

namespace Tests\Feature\Resource;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteResourceTest extends TestCase
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

    public function test_delete_resource_success(): void
    {
        $response = $this->deleteJson(route('resources.destroy', $this->resource->id));
        $response->assertSuccessful();

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson([
            'message' => __('messages.resource_deleted')
        ]);

        $this->assertDatabaseMissing('resources', [
            'id' => $this->resource->id,
        ]);
    }

    public function test_delete_resource_fail(): void
    {
        $this->resource->delete();

        $response = $this->deleteJson(route('resources.destroy', $this->resource->id));

        $response->assertStatus(404);
    }

    public function test_delete_resource_as_authorized_user(): void
    {
        $this->user = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($this->user);


        $response = $this->deleteJson(route('resources.destroy', $this->resource->id));
        $response->assertForbidden();

        $response->assertJsonStructure([
            'message'
        ]);

        $response->assertJson([
            'message' => __('messages.access_denied'),
        ]);
    }
}
