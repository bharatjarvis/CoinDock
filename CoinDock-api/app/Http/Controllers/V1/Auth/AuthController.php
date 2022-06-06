<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Requests\V1\CreateUserRequest;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Requests\V1\SignupRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\V1\{User,SignUp};
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends AccessTokenController
{
    use BuildPassportTokens;

    public function signUpInfo(User $user)
    {
        $signUp = SignUp::find($user->id);

        $resultArr = [
            'step_1_completed' => false,
            'step_2_completed' => false,
            'step_3_completed' => false
        ];

        $stepCount = $signUp->step_count;

        if($stepCount == 0) {
            return response([
                'message' => 'Signup not completed',
                'results' => [
                    'step_details' => $resultArr
                ]
            ], 
            200);
        }

        foreach(range(1, $stepCount) as $i) {
            $resultArr["step_{$i}_completed"] = true;
        }

        return response(['message' => 'Signup details',
            'results' => [
                'step_details' => $resultArr
            ]], 200);
    }


    /**
     * SignupRequest
     */
    public function store(CreateUserRequest $request)
    {
        info("message");
        $user = new User();

        $user->store($request);
        
        return response(['status' => 'success', 'message' => 'Success! User registered.'], 201);
    }


    /**
     * Login
     */
    public function login(LoginRequest $request)
    {
        // checking if the user data was existing in the database or not
        if (!Auth::once($request->only('email', 'password'))) {
            throw new AuthenticationException('Email or password incorrect');
        }

        $response = $this->requestPasswordGrant($request);

        $user = User::whereEmail($request->email)->first();

        return response(
            [
                'message' => 'Login Successfull.',
                'results' => [
                    'user' => UserResource::make($user)->resolve(),
                    'Access-Token' => $response['access_token']
                ]
            ],
            Response::HTTP_OK,
            [
                'Access-Token' => $response['access_token'],
                'Refresh-Token' => $response['refresh_token'],
                'Expires-In' => $response['expires_in']
            ]
        );
    }

    /**
     * Logout
     *
     */
    public function logout()
    {
        auth()->user()->tokens->map(fn ($token) => $token->delete());

        return response(['message' => 'Successfully logged out'], 200);
    }

    public function refresh(Request $request)
    {
        $response = $this->requestRefreshGrant($request);

        return response(
            ['message' => 'Refreshed token successfully',],
            Response::HTTP_OK,
            [
                'Access-Token' => $response['access_token'],
                'Refresh-Token' => $response['refresh_token'],
                'Expires-In' => $response['expires_in']
            ]
        );
    }
}