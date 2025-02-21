<?php

namespace App\Http\Controllers\api\v1\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\StoreBookingRequest;
use App\Http\Resources\Booking\BookingResource;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        //
    }


    public function store(StoreBookingRequest $request)
    {
        $resource = Resource::query()->findOrFail($request->resource_id);

        $startTime = $request->start_time;
        $endTime = $request->end_time;

        // Проверка наличия пересекающегося бронирования
        $existingBooking = $resource->bookings()
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<=', $endTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->exists();

        if ($existingBooking) {
            return response()->json([
                'message' => __('messages.resource_is_already_booked_for_this_time')
            ], 400);
        }

        // Создание бронирования
        $booking = $resource->bookings()->create($request->validated());

        return response()->json([
            'message' => __('messages.booking_created_successfully'),
            'booking' => new BookingResource($booking)
        ], 201);
    }

    public function destroy()
    {
        //
    }
}
