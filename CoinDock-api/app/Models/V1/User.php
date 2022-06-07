<?php

namespace App\Models\V1;

use App\Enums\V1\UserType;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Requests\V1\SignupRequest;
use App\Models\V1\Traits\Encryptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'type',
        'date_of_birth',
        'country',
        'email',
        'password',
        're_enter_password',
        'status',
        'recovery_attemps'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        're_enter_password',
        'remember_token',
    ];

    // protected $encryptable = ['date_of_birth'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table= 'users';

    /**
     * @param string $value
     *
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }


    public function recoveryKey()
    {
        return $this->hasOne(RecoveryKey::class);
    }

    public function store(SignupRequest $request): self
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'type' => 1,
            'date_of_birth' => $request->date_of_birth,
            'country' => $request->country,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            're_enter_password' =>bcrypt($request->re_enter_password),
            'status'=>1
        ]);

        $signup = $this->signUp;
        if($signup){
            $signup->step_count+=1;
            $signup->save();
        }

        SignUp::create(['step_count'=>1,'user_id'=>$user->id]);
 
        return $user;
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

    public function recoveryKeys()
    {
        $this->hasOne(RecoveryKey::class, 'user_id', 'id');
    }
}
