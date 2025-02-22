<?php

namespace Tests\Feature\Mail;

use App\Mail\BookingCanceledForAdminMail;
use App\Mail\BookingCanceledMail;
use App\Mail\BookingCreatedForAdminMail;
use App\Mail\BookingCreatedMail;
use App\Models\Booking;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class BookingObserverTest extends TestCase
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

    public function test_booking_created_sends_emails(): void
    {
        Mail::fake();

        $booking = Booking::factory()->create([
            'user_id' => $this->user->id,
            'resource_id' => $this->resource->id,
        ]);

        Mail::assertQueued(BookingCreatedMail::class, function ($mail) use ($booking) {
            return $mail->hasTo($booking->user->email);
        });

        Mail::assertQueued(BookingCreatedForAdminMail::class, function ($mail) {
            return $mail->hasTo(config('seed.mail_admin'));
        });

    }

    public function test_booking_canceled_sends_emails(): void
    {
        Mail::fake();

        $booking = Booking::factory()->create([
            'user_id' => $this->user->id,
            'resource_id' => $this->resource->id,
        ]);

        $booking->delete();

        Mail::assertQueued(BookingCanceledMail::class, function ($mail) use ($booking) {
            return $mail->hasTo($booking->user->email);
        });

        Mail::assertQueued(BookingCanceledForAdminMail::class, function ($mail) {
            return $mail->hasTo(config('seed.mail_admin'));
        });
    }
}
