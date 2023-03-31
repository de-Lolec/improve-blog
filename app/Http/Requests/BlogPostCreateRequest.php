<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogPostCreateRequest extends FormRequest
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
            'title' => 'required|min:3|max:150|unique:blog_posts',
            'slug' => 'max:200|unique:blog_posts',
            'content_raw' => 'required|string|max:10000|min:5',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'excerpt' => 'max:150'
        ];
    }

    // Переводим ошибки, то что сверху, ошибки можно посмотреть дефолтные в файле config
    public function messages()
    {
        return [
            'title.required' => 'Введите заголовок статьи',
            'title.max' => 'Слишком большой заголовок',
            'excerpt.max' => 'Слишком большая выдержка, максимальная длина 150 символов',
            'image.max' => 'Максимальный размер :max Кб',
            'content_raw.min' => 'Минимальная длина статьи [:min] символов',
            'image.required' => 'Загрузите превью',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Заголовок',
        ];
    }
}
