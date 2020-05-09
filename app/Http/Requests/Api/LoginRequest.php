<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email'       => 'required|string|email|exists:users,email',
            'password'    => 'required|string',
            'device_name' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'device' => [
                'required' => 'The device name field is required.',
                'string'   => 'The device name must be a string.',
            ],
        ];
    }
}
