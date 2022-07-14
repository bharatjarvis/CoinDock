<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\V1\Auth\BuildPassportTokens;
use App\Http\Requests\V1\CreateUserRequest;
use App\Http\Requests\V1\updatePasswordRequest;
use App\Http\Requests\V1\updateProfileRequest;
use App\Models\V1\Setting;
use App\Models\V1\User;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AccessTokenController
{
    use BuildPassportTokens;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateUserRequest $request)
    {
        $user = new User();
        $userData = $user->store($request);

        $response = $this->requestPasswordGrant($request);
        
        return response(
            ['status' => 'success', 'message' => 'Success! User registered.'
                
        ],
            Response::HTTP_OK,
            [
                'Access-Token' => $response['access_token'],
                'Refresh-Token' => $response['refresh_token'],
                'Expires-In' => $response['expires_in'],
            ],
        );
    }

    public function changePassword(updatePasswordRequest $request, User $user)
    {
        return $user->changePassword($request,$user);
    }


    public function updateProfile(updateProfileRequest $request, User $user)
    {
        return $user->updateProfile($request,$user);

    }

    
}
