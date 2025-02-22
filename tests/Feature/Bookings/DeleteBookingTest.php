<?php

namespace Tests\Feature\Bookings;

use App\Models\Booking;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteBookingTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Resource $resource;
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'user']);
        $this->resource = Resource::factory()->create();

        Sanctum::actingAs($this->user);
    }

    public function test_user_can_delete_their_own_booking()
    {
        $relations = [
            'user_id' => $this->user->id,
            'resource_id' => $this->resource->id,
        ];

        $booking = Booking::factory()->create($relations);

        $response = $this->deleteJson(route('bookings.destroy', $booking->id));
        $response->assertSuccessful();

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson([
            'message' => __('messages.booking_deleted_successfully'),
        ]);

        $this->assertDatabaseMissing('bookings', ['id' => $booking->id]);
    }

    public function test_cannot_delete_non_existing_booking_twice()
    {
        $relations = [
            'user_id' => $this->user->id,
            'resource_id' => $this->resource->id,
        ];

        $booking = Booking::factory()->create($relations);

        $response = $this->deleteJson(route('bookings.destroy', $booking->id));
        $response->assertSuccessful();


        $response = $this->deleteJson(route('bookings.destroy', $booking->id));
        $response->assertNotFound();
    }

    public function test_user_cannot_delete_a_booking_that_is_not_his_own()
    {
        $user2 = User::factory()->create();

        $relations = [
            'user_id' => $user2->id,
            'resource_id' => $this->resource->id,
        ];

        $booking = Booking::factory()->create($relations);

        $response = $this->deleteJson(route('bookings.destroy', $booking->id));
        $response->assertForbidden();

        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson([
            'message' => __('messages.you_have_no_rights'),
        ]);

        $this->assertDatabaseHas('bookings', ['id' => $booking->id]);
    }
}
