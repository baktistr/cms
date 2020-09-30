<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdatePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    /**
     * Update the user account password.
     *
     * @param \App\Http\Requests\Api\UpdatePasswordRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePasswordRequest $request)
    {
        $request->user()->update(['password' => Hash::make($request->get('new_password'))]);

        return response(null, 201);
    }
}
