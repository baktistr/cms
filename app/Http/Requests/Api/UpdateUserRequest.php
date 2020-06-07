<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name'         => 'required|string',
            'username'     => [
                'required',
                'alpha_num',
                Rule::unique('users', 'username')->ignore($this->user()->id),
            ],
            'email'        => [
                'required',
                'email:strict,dns',
                Rule::unique('users')->ignore($this->user()->id),
            ],
            'address'      => 'nullable',
            'phone_number' => 'required|phone:ID',
        ];
    }
}
