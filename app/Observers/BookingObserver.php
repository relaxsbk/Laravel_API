<?php

namespace App\Observers;

use App\Mail\BookingCanceledForAdminMail;
use App\Mail\BookingCanceledMail;
use App\Mail\BookingCreatedForAdminMail;
use App\Mail\BookingCreatedMail;
use App\Models\Booking;
use Illuminate\Support\Facades\Mail;

class BookingObserver
{
    protected string $adminEmail;

    public function __construct()
    {
        $this->adminEmail = config('seed.mail_admin');
    }

    public function created(Booking $booking): void
    {
        Mail::to($booking->user->email)->send(new BookingCreatedMail($booking));

        Mail::to($this->adminEmail)->send(new BookingCreatedForAdminMail($booking));
    }


    public function deleted(Booking $booking): void
    {
        $bookingData = $this->getBookingData($booking);

        Mail::to($booking->user->email)->send(new BookingCanceledMail($bookingData));

        Mail::to($this->adminEmail)->send(new BookingCanceledForAdminMail($bookingData));
    }

    protected function getBookingData(Booking $booking): array
    {
        return [
            'user' => $booking->user->name,
            'resource' => $booking->resource->name ,
        ];
    }
}
