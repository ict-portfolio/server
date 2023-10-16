<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UserRequest extends FormRequest
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
        if (request()->route()->getName() == 'register') {
            return [
                'name' => ['required'],
                'email' => ['required' , 'email' , 'unique:users,email'],
                'password' => ['required' , 'min:8' , 'max:16' , 'confirmed']
            ];
        } else {
            return [
                'email' => ['required' , 'email'],
                'password' => ['required']
            ];
        }

    }
    public function messages()
    {
        return [
            'required' => 'Please fill up the :attribute field.',
            'email' => 'Please fill up a valid email address.',
            'unique' => 'There is a user with this email',
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'full name',
            'email' => 'email address'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator , response()->json([
            'errors' => $validator->errors()
        ],422));
    }
}
