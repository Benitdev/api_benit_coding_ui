<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardRequest extends FormRequest
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
            'user_id' => 'required|max:255',
            'filter_id' => 'required|max:255',
            'title' => 'required|string|max:50',
            'html_code' => 'required|string',
            'css_code' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'User ID invalid',
            'filter_id.required' => 'Filter ID invalid',
            'title.required' => 'Title invalid',
            'html_code.required' => 'HTML Code invalid',
            'css_code.required' => 'CSS Code invalid',
        ];
    }
}
