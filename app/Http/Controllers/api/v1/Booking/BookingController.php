<?php

namespace App\Http\Controllers\api\v1\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\StoreBookingRequest;
use App\Http\Resources\Booking\BookingResource;
use App\Models\Booking;
use App\Repositories\Bookings\BookingRepository;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BookingController extends Controller implements HasMiddleware
{
    public function store(BookingRepository $bookingRepository, StoreBookingRequest $request)
    {
        $resourceId = $request->resource_id;
        $startTime = $request->start_time;
        $endTime = $request->end_time;

        if ($bookingRepository->isResourceBooked($resourceId, $startTime, $endTime)) {
            return response()->json([
                'message' => __('messages.resource_is_already_booked_for_this_time')
            ], 400);
        }

        $booking = $bookingRepository->createBooking($request->validated());

        return response()->json([
            'message' => __('messages.booking_created_successfully'),
            'booking' => new BookingResource($booking)
        ], 201);
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return response()->json([
            'message' => __('messages.booking_deleted_successfully')
        ]);
    }


    public static function middleware()
    {
        return [
            new Middleware(['auth:sanctum'], only: ['store','destroy']),
            new Middleware(['cancelBooking'], only: ['destroy']),
        ];
    }
}
