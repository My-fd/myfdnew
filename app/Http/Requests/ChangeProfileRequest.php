<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'        => 'required|string|email|max:255|unique:users,email',
            'name'         => 'required|string|max:64',
            'surname'      => 'required|string|max:64',
            'patronymic'   => 'nullable|string|max:64',
            'about'        => 'nullable|string|max:1024',
            'phone'        => 'required|string|max:20|unique:users,phone',
            'country_code' => 'required|string|max:5',
        ];
    }
}
