<?php

namespace App\Http\Requests\Admin\Rubric;

use Illuminate\Foundation\Http\FormRequest;

class UpsertRubricRequest extends FormRequest
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
            'rubric.title' => 'string|unique:rubrics,title',
            'rubric.order' => 'integer|unique:rubrics,order',
            'rubric.is_preferable' => 'required|boolean',
            'rubric.is_visible' => 'required|boolean'
        ];
    }
}
