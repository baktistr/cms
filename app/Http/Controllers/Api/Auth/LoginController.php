<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle an API login request to the application.
     *
     * @param \App\Http\Requests\Api\LoginRequest $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // return $user->createToken($request->device_name)->plainTextToken

        return [
            'success' => 'true',
            'message' => "",
            'token'   => $user->createToken($request->device_name)->plainTextToken
        ];
    }
}
