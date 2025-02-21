<?php

namespace Tests\Feature\Bookings;

use App\Models\Booking;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class StoreBookingTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Resource $resource;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->resource = Resource::factory()->create();
    }

    public function test_store_booking_successfully()
    {
        $data = [
            'user_id' => $this->user->id,
            'resource_id' => $this->resource->id,
            'start_time' => Carbon::now()->addHour()->toDateTimeString(),
            'end_time' => Carbon::now()->addHours(2)->toDateTimeString(),
        ];

        $response = $this->postJson(route('bookings.store'), $data);

        $response->assertCreated();

        $response->assertJsonStructure([
            'message', 'booking'
        ]);

        $response->assertJson([
            'message' => __('messages.booking_created_successfully'),
            'booking' => [
                'user_id' => $this->user->id,
                'resource_id' => $this->resource->id,
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
            ]
        ]);

        $this->assertDatabaseHas('bookings', [
            'user_id' => $this->user->id,
            'resource_id' => $this->resource->id,
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
        ]);
    }

    public function test_store_booking_with_over_lapping_times()
    {
        Booking::query()->create([
            'user_id' => $this->user->id,
            'resource_id' => $this->resource->id,
            'start_time' => Carbon::now()->addHour()->toDateTimeString(),
            'end_time' => Carbon::now()->addHours(2)->toDateTimeString(),
        ]);

        $data = [
            'user_id' => $this->user->id,
            'resource_id' => $this->resource->id,
            'start_time' => Carbon::now()->addMinutes(30)->toDateTimeString(), // Пересекается
            'end_time' => Carbon::now()->addHours(1)->toDateTimeString(),
        ];

        $response = $this->postJson(route('bookings.store'), $data);

        $response->assertStatus(400);

        $response->assertJson([
            'message' => __('messages.resource_is_already_booked_for_this_time')
        ]);
    }

    public function test_store_booking_with_invalid_data()
    {
        $data = [
            'user_id' => 999,
            'resource_id' => 999,
            'start_time' => 'invalid_date',
            'end_time' => 'invalid_date',
        ];

        $response = $this->postJson(route('bookings.store'), $data);


        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'user_id', 'resource_id', 'start_time', 'end_time'
        ]);
    }

    public function test_store_booking_without_required_fields()
    {
        $data = [
            'user_id' => '',
            'resource_id' => '',
            'start_time' => '',
            'end_time' => '',
        ];

        $response = $this->postJson(route('bookings.store'), $data);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'user_id', 'resource_id', 'start_time', 'end_time'
        ]);
    }

    public function test_store_booking_with_invalid_start_time()
    {
        $data = [
            'user_id' => $this->user->id,
            'resource_id' => $this->resource->id,
            'start_time' => Carbon::now()->addDays(1)->toDateTimeString(),
            'end_time' => Carbon::now()->addDays(1)->subHour()->toDateTimeString(),
        ];

        $response = $this->postJson(route('bookings.store'), $data);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['start_time']);
    }
}
