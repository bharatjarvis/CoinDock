<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Requests\V1\SignupRequest;
use Illuminate\Http\Request;
use App\Models\V1\User;
use App\Models\V1\SignUp;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * SignupRequest
     */
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

    public function store(SignupRequest $request)
    {
        $user = new User();

        $user->store($request);

        $user->createToken('Laravel')->accessToken;

        return response(
            [
                'status' => 'success', 
                'error' => false, 
                'message' => 'Success! User registered.'
            ], 
            201
        );
    }


    /**
     * Login
     */
    public function login(LoginRequest $request)
    {
        $user = new User();

       $user->login( $request);

       info(auth()->user());
        
       return response(
            [
                'message' => 'Login Successfull.', 
                'token' => auth()->user()->getRememberToken()
            ],
            200
        );

    }

    /**
     * Logout
     *
     */
    public function logout()
    {
        auth()->user()->tokens->map(fn ($token) => $token->delete());

        return response(
            [ 'message' => 'Successfully logged out' ], 
            200
        );
    }
}

