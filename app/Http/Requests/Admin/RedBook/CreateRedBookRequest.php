<?php

namespace App\Http\Requests\Admin\RedBook;

use Illuminate\Foundation\Http\FormRequest;

class CreateRedBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'name_latin' => 'required',
            'content' => 'required',
            'slug'  => 'required',
            'preview_image_big' => 'required|image',
            'preview_image_small' => 'required|image',
        ];
    }
}
