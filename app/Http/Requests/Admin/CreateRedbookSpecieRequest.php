<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateRedbookSpecieRequest extends FormRequest
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
            'name' => 'required',
            'name_latin' => 'required',
            'domain' => 'required',
            'type' => 'required',
            'class'=> 'required',
            'squad' => 'required',
            'family' => 'required',
            'genus' => 'required',
            'kind' => 'required',
            'content' => 'required',
            'status' => 'required|array',
            'facts'  => ' required|array'
        ];
    }
}
