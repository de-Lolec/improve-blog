<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogPostUpdateRequest extends FormRequest
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
                'title' => 'required|min:3|max:200',
                'slug' => 'max:200',
                'excerpt' => 'max:150',
                'content_raw' => 'required|string|max:10000|min:5',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Введите заголовок статьи',
            'title.max' => 'Слишком большой заголовок',
            'excerpt.max' => 'Слишком большая выдержка, максимальная длина 150 символов',
            'image.max' => 'Максимальный размер :max Кб',
            'content_raw.min' => 'Минимальная длина статьи [:min] символов',
        ];
    }
}
