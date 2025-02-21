<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;


class StoreBookingRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'resource_id' => ['required', 'integer', 'exists:resources,id'],
            'start_time' => ['required', 'date', 'date_format:Y-m-d H:i:s','before:end_time'],
            'end_time' => ['required', 'date', 'date_format:Y-m-d H:i:s', 'after:start_date'],
        ];
    }


}
