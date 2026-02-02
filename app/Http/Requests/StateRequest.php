<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:250',
            'code' => 'nullable|max:250',
            'country' => 'required|exists:countries,id',
            'status' => 'required|in:0,1'
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => translation('Name is required'),
            'country.required' => translation('Please select a country'),
            'country.exists' => translation('Invalid country'),
        ];
    }
}
