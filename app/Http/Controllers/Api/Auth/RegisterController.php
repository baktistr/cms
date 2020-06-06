<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\Auth\Registered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Handle a registration request for the application.
     *
     * @param \App\Http\Requests\Api\RegisterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        event(new Registered($user = $this->create($request->validated())));

        return response()->json([
            'message' => 'Register successfull.',
            'data'    => [
                'user' => $user,
            ],
        ], 201);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'         => $data['name'],
            'username'     => $data['username'],
            'email'        => $data['email'],
            'phone_number' => $data['phone_number'],
            'address'      => $data['address'],
            'password'     => Hash::make($data['password']),
        ]);
    }
}
