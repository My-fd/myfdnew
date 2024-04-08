<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'country'         => 'required|string|max:255',
            'city'            => 'required|string|max:255',
            'street'          => 'required|string|max:255',
            'house_number'    => 'required|string|max:50',
            'floor'           => 'nullable|string|max:50',
            'zip'             => 'required|string|max:20',
            'additional_info' => 'nullable|string|max:255',
        ];
    }
}
