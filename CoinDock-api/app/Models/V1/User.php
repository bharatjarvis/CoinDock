<?php

namespace App\Models\V1;

use App\Enums\V1\UserStatus;
use App\Enums\V1\UserType;
use App\Models\V1\{Coin, Signup};
use App\Http\Requests\V1\CreateUserRequest;
use App\Http\Requests\V1\updatePasswordRequest;
use App\Http\Requests\V1\updateProfileRequest;
use App\Http\Resources\V1\UserResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Symfony\Component\HttpFoundation\Response;

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
        'status',
        'recovery_attempts',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'users';

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

    public function store(CreateUserRequest $request): self
    {
        $user = $this::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'type' => UserType::User,
            'date_of_birth' => $request->date_of_birth,
            'country' => $request->country,
            'email' => $request->email,
            'password' => $request->password,
            'status' => UserStatus::Active,
        ]);
        // REGISTRATION STATUS UPDATION -  STEP:1
        $signup = $this->signup;
        if($signup){
            $signup->step_count+=1;
            $signup->save();
        }

        Signup::create(['step_count' => 1, 'user_id' => $user->id]);

        return $user;
    }


    public function signUp()
    {
        return $this->hasOne(Signup::class);
    }

    public function updateProfile(updateProfileRequest $request, User $user)
    {
        $updatedUser = $request->all();
        $user->update($updatedUser);
        return response([
            'message' => 'Profile updated succesfully',
            'results'=>[
                'user'=>new UserResource($user)
            ]
        ],Response::HTTP_OK );
    }

    public function changePassword(updatePasswordRequest $request, User $user)
    {
        $updatedPassword = $request->password;
        
        $this::whereId($user->id)->update(['password' => bcrypt($updatedPassword)]);
        return response([
            'message' => 'Password has been updated successfully',
        ],Response::HTTP_OK );
    }

    public function settings(){
        return $this->hasOne('App\Models\V1\Setting');
    }
}
