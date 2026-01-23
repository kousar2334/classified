<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
    public function rules(Request $request)
    {
        if ($request->has('id') && $request['id'] != null) {
            return [
                'name' => 'required|max:250',
                'phone' => 'required|phone:BD|max:250|unique:users,phone,' . $request->id,
                'email' => 'required|max:250|email|unique:App\Models\User,email,' . $request->id
            ];
        } else {
            return [
                'name' => 'required|max:250',
                'password' => 'required|confirmed|min:6|max:250',
                'phone' => 'required|phone:BD|max:250|unique:users,phone',
                'email' => 'required|max:250|email|unique:App\Models\User,email',
                // 'terms_conditions' => 'accepted'
            ];
        }
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
            'password.required' => translation('Password is required'),
            'password.confirmed' => translation('Password does not match'),
            'password.min' => translation('Password is too short'),
            'phone.required' => translation('Phone is required'),
            'phone.phone' => translation('Incorrect phone number'),
            'phone.unique' => translation('Phone is already used'),
            'email.required' => translation('Email is required'),
            'email.email' => translation('Incorrect email'),
            'email.unique' => translation('Email is already used'),
        ];
    }
}
