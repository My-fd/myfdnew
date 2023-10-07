<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => 'required|string',
            'image' => 'image|max:2048', // Поддерживаемые изображения и максимальный размер 2MB (2048 килобайт)
        ];
    }

    /**
     * Описание ошибок
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Имя является обязательным полем',
            'image.image'   => 'Файл должен быть изображением',
            'image.max'     => 'Максимальный размер изображения - 2MB',
        ];
    }
}
