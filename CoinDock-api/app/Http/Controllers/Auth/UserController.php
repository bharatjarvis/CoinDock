<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\v1\User;

class UserController extends Controller
{
    //

     /**
     * Registration
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
            'user_type' => 'required|string',
            'date_of_birth' => 'required|date|before_or_equal:'.\Carbon\Carbon::now()->subYears(15)->format('Y-m-d'),
            'country' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|max:12',
            're_enter_password' => 'required|max:12|same:password',
            //'password' => 'required|max:12|min:4|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/| confirmed',
             //'re_enter_password' => 'required|same:password',
            'status' => 'required'
        ],[
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'date_of_birth.required' => 'Date of birth reqired.',
            'date_of_birth.required' => 'You need to be 15 years old to register for CoinDock',
            'country.requried' => 'Country required.',
            'email.required' => 'Email field is required.',
            'email.email' => 'Email field must be email address.',
            'password.required' => 'Password is required.Password must be at least 12 characters.
                                                        Password must contain at least one number.
                                                        Your password must include at least one letter.
                                                        Password must contain at least one special character, e.g. @$!%*#?&"',
            're_enter_password.required' =>'Passwords are not matching',
            'status.required' => 'status is required.'
            
            
        ]);
 
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
       
        $token = $user->createToken('LaravelAuthApp')->accessToken;
 
        return response()->json(['token' => $token], 200);
        return response()->json($user);
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
 
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['message' =>" Login Successfull."], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    } 
    
    



    public function logout()
{
    auth()->user()->token()->revoke();

    return response()->json([
        'message' => 'Successfully logged out'
    ],200);
}
}
