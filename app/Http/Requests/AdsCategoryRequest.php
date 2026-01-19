<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdsCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|max:250',
        ];
    }

    public function messages()
    {

        return [
            'title.required' => translation('Title is required'),
            'permalink.required' => translation('Permalink is required'),
            'permalink.unique' => translation('Permalink is already exists'),
            'parent.exists' => translation('Selected parent does not exists'),

        ];
    }
}
