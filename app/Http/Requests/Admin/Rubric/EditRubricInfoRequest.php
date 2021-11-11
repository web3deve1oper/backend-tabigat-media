<?php

namespace App\Http\Requests\Admin\Rubric;

use Illuminate\Foundation\Http\FormRequest;

class EditRubricInfoRequest extends FormRequest
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
            'rubrics' => 'array',
            'rubrics.*.order' => 'distinct',
            'rubric.*.title' => 'required|string',
            'rubric.*.slug' => 'required|string|distinct'
        ];
    }
}
