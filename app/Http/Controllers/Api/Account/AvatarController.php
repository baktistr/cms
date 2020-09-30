<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateAvatarRequest;
use Illuminate\Http\Request;

class AvatarController extends Controller
{
    /**
     * Update the specified avatar in storage.
     *
     * @param \App\Http\Requests\Api\UpdateAvatarRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAvatarRequest $request)
    {
        $request->user()->addMedia($request->file('avatar'))
            ->toMediaCollection('avatar');

        return response(null, 201);
    }
}
