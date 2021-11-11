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
            'rubric.title' => 'required|string|unique:rubrics,title',
            'rubric.slug' => 'required|string|unique:rubrics,slug',
            'rubric.order' => 'required|integer|unique:rubrics,order'
        ];
    }
}
