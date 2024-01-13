<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'        => ['nullable', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore(auth()->user()->id)],
            'name'         => 'nullable|string|max:64',
            'surname'      => 'nullable|string|max:64',
            'patronymic'   => 'nullable|string|max:64',
            'about'        => 'nullable|string|max:1024',
            'phone'        => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone')->ignore(auth()->user()->id)],
            'country_code' => 'nullable|string|max:5',
        ];
    }
}
