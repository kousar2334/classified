<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $lang = $this->input('lang', defaultLangCode());
        $isDefaultLang = $lang == defaultLangCode();

        $rules = [
            'name' => 'required|max:250',
            'lang' => 'nullable|string|max:10',
        ];

        if ($isDefaultLang) {
            $rules['code']    = 'nullable|max:250';
            $rules['country'] = 'required|exists:countries,id';
            $rules['status']  = 'required|in:0,1';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'    => translation('Name is required'),
            'country.required' => translation('Please select a country'),
            'country.exists'   => translation('Invalid country'),
        ];
    }
}
