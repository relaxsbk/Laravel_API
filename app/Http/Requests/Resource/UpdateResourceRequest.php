<?php

namespace App\Http\Requests\Resource;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResourceRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'type' => ['string', 'max:255'],
            'description' => ['string', 'max:255'],
            'available' => ['boolean'],
        ];
    }
}
