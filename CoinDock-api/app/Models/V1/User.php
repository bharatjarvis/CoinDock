<?php

namespace App\Models\V1;

use App\Enums\V1\UserType;
use App\Models\V1\RecoveryKey;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use App\Models\V1\Traits\Encryptable;
use App\Http\Requests\V1\SignupRequest;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Encryptable;

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
        're_enter_password',
        'remember_token',
    ];

    protected $encryptable = ['date_of_birth'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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
        return User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'type' => UserType::User,
            'date_of_birth' => $request->date_of_birth,
            'country' => $request->country,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            're_enter_password' =>bcrypt($request->re_enter_password),
            'status'=> $request->status
        ]);
    }

}