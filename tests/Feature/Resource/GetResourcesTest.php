<?php

namespace Tests\Feature\Resource;

use App\Models\Resource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetResourcesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Resource::factory(5)->create();
    }

    public function test_get_resources(): void
    {
        $response = $this->get(route('resources.index'));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            '*' => [
                'id', 'name', 'type', 'description',
            ]
        ]);
    }
}
