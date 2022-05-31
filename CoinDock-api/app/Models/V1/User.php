<?php

namespace App\Models\V1;

use App\Enums\userType;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Requests\V1\SignupRequest;
use App\Models\V1\User as V1User;
use GuzzleHttp\Psr7\Request;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use  HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'user_type',
        'date_of_birth',
        'country',
        'email',
        'password',
        're_enter_password',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function store(SignupRequest $request): self
    {
        return User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'type' => userType::User,
            'date_of_birth' => $request->date_of_birth,
            'country' => $request->country,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            're_enter_password' =>bcrypt($request->re_enter_password),
            'status'=> $request->status
        ]);
    }

    public function login(LoginRequest $request){
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (!auth()->attempt($data)) {
            return response(
                [
                    'error' => 'unauthorised'
                ],
                401
            );
        }
    }


    public function signUp(){
        return $this->hasOne(SignUp::class);
    }    

}


