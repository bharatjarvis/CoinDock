<?php

namespace App\Http\Controllers\V1;


use App\Http\Requests\V1\SignupRequest;
use App\Models\V1\User;
use Laravel\Passport\Http\Controllers\AccessTokenController;

class UserController extends AccessTokenController
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(SignupRequest $request)
    {
        $user = new User();

        $user->store($request);

        return response(['status' => 'success', 'message' => 'Success! User registered.'], 200);
    }

}