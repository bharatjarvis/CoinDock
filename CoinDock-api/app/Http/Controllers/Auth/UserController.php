<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\SignupRequest;
use Illuminate\Http\Request;
use App\Models\V1\User;
use League\Uri\Http;

class UserController extends Controller
{
    //

    // protected function generateAccessToken($user){
    //     $token= $user->createToken($user->email. '-'.now());
    //     return $token->accessToken;
    // }

     /**
     * Registration
     */
    public function register(SignupRequest $request)
    {
        $this->validate($request, [
        ],);
 
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'user_type' => $request->user_type,
            'date_of_birth' => $request->date_of_birth,
            'country' => $request->country,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            're_enter_password' =>bcrypt($request->re_enter_password),
            'status'=> $request->status
        ]);
       
        $token = $user->createToken('Laravel')->accessToken;
        return response()->json(["status" => "success", "error" => false, "message" => "Success! User registered."], 201);
    }
    

    /**
     * Login
     */
    
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (!auth()->attempt($data)) {
            return response(['error' => 'Unauthorised'], 401);
        }
   
        $token = auth()->user()->getRememberToken();

        return response(['message' =>" Login Successfull.", 'token'=> $token], 200);
        
    } 

    public function logout()
    {
        auth()->user()->tokens->delete();
    
        return response([
            'message' => 'Successfully logged out',
        ], 200);
    }
}

