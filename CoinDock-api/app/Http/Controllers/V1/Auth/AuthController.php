<?php

namespace App\Http\Controllers\V1\Auth;

use App\Exceptions\AuthenticationException;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\V1\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends AccessTokenController
{
    use BuildPassportTokens;

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
                ],
            ],
            Response::HTTP_OK,
            [
                'Access-Token' => $response['access_token'],
                'Refresh-Token' => $response['refresh_token'],
                'Expires-In' => $response['expires_in'],
            ],
        );
    }

    /**
     * Logout
     *
     */
    public function logout()
    {
        auth()
            ->user()
            ->tokens->map(fn($token) => $token->delete());

        return response(['message' => 'Successfully logged out'], 200);
    }

    public function refresh(Request $request)
    {
        $response = $this->requestRefreshGrant($request);
       
        return response(['message' => 'Refreshed token successfully'], Response::HTTP_OK, [
            'Access-Token' => $response['access_token'],
            'Refresh-Token' => $response['refresh_token'],
            'Expires-In' => $response['expires_in'],
        ]);
    }
}