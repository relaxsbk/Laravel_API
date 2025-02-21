<?php

namespace App\Repositories\Bookings;

use App\Models\Booking;
use App\Models\Resource;

class BookingRepository
{
    public function isResourceBooked(int $resourceId, string $startTime, string $endTime): bool
    {
        return Booking::query()->where('resource_id', $resourceId)
            ->isOverlapping($startTime, $endTime)
            ->exists();
    }

    public function createBooking(array $data): Booking
    {
       return Booking::query()->create($data);
    }

}
