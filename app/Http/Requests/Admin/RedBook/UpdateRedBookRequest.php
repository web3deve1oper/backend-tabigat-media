<?php

namespace App\Http\Requests\Admin\RedBook;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRedBookRequest extends FormRequest
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
            'preview_image_big' => 'required|image',
            'preview_image_small' => 'required|image',
            'id' => 'required|exists:red_book,id',
            'name' => 'required',
            'name_latin' => 'required',
            'slug' => 'required'
        ];
    }
}
