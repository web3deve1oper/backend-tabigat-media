<?php

namespace App\Http\Requests\Admin\PageSetting;

use Illuminate\Foundation\Http\FormRequest;

class StorePageSettingsRequest extends FormRequest
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
            'pages.about' => 'string',
            'pages.confidentiality_policy' => 'string',
            'pages.legal_information' => 'string'
        ];
    }
}
