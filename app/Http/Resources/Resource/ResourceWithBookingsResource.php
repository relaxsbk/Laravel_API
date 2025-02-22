<?php

namespace App\Http\Resources\Resource;

use App\Http\Resources\Booking\MiniBookingResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResourceWithBookingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge((new ResourceResource($this))->toArray($request), [
            'bookings' => MiniBookingResource::collection($this->bookings)
        ]);
    }
}
