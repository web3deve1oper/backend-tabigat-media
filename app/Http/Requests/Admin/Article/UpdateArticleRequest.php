<?php

namespace App\Http\Requests\Admin\Article;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
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
            'preview_image_big' => 'image',
            'preview_image_small' => 'required|image',
            'id' => 'exists:articles,id',
            'title' => 'required',
            'description' => 'required',
            'slug' => 'required',
        ];
    }
}
