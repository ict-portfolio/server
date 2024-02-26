<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "service_id" => "required",
            "phone" => "required|numeric",
            "comment" => "required",
            "status" => "required|in:requested,confimed,completed,canceled",
            "appointment_date" => "required|date_format:Y-m-d H:i:s",
        ];
    }

    public function validated($key = null, $default = null) {
        $data = parent::validated($key, $default);
        $data['user_id'] = auth()->id();
        return $data;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator,response()->json([
            "errors" => $validator->errors(),
            "message" => "validation errors"
        ],422));
    }
}
