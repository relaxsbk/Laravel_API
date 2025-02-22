<?php

namespace Tests\Feature\Resource;

use App\Models\Booking;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class GetResourceWithBookingsTest extends TestCase
{
    protected User $user;
    protected Resource $resource;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->resource = Resource::factory()->create(['available' => 1]);
    }

    public function test_get_resource_with_bookings(): void
    {
        $booking = Booking::factory()->create([
            'resource_id' => $this->resource->id,
            'user_id' => $this->user->id,
            'start_time' => Carbon::now()->addHour()->toDateTimeString(),
            'end_time' => Carbon::now()->addHours(2)->toDateTimeString(),
        ]);

        $response = $this->getJson(route('resources.bookings', $this->resource->id));

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'id', 'name', 'type', 'description', 'available', 'createdAt', 'bookings'
        ]);

        $response->assertJson([
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'type' => $this->resource->type,
            'description' => $this->resource->description,
            'available' => $this->resource->available,
            'createdAt' => $this->resource->createdAt(),
            'bookings' => [
                [
                    'user' => $this->user->name,
                    'start_time' => Carbon::parse($booking->start_time)->toDateTimeString(),
                    'end_time' => Carbon::parse($booking->end_time)->toDateTimeString(),
                ],
            ],
        ]);
    }

    public function test_get_resource_with_not_bookings(): void
    {
        $response = $this->getJson(route('resources.bookings', $this->resource->id));

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'id', 'name', 'type', 'description', 'available', 'createdAt', 'bookings'
        ]);

        $response->assertJson([
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'type' => $this->resource->type,
            'description' => $this->resource->description,
            'available' => $this->resource->available,
            'createdAt' => $this->resource->createdAt(),
            'bookings' => [],
        ]);
    }

    public function test_get_resource_not_found(): void
    {
        $resource = Resource::factory()->create(['available' => 0]);

        $response = $this->get(route('resources.bookings', $resource->id));

        $response->assertNotFound();
        $response->assertJsonStructure(['message']);
        $response->assertJson(['message' => __('messages.resource_not_found')]);
    }
}
