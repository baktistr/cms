<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name'         => 'required|string|max:255',
            'username'     => 'required|alpha_num|unique:users,username',
            'email'        => 'required|string|max:255|email:strict,dns|unique:users,email',
            'phone_number' => 'required|phone:ID',
            'address'      => 'nullable',
            'password'     => 'required|min:8',
        ];
    }
}
