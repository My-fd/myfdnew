<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreListingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'price'        => 'required|numeric|min:0',
            'category_id'  => 'required|integer|exists:categories,id',
            'attributes'   => 'sometimes|array',
            'attributes.*' => 'string',
            'images'       => 'sometimes|array',
            'images.*'     => 'image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'category_id.exists' => 'Выбрана неверная категория',
        ];
    }
}
