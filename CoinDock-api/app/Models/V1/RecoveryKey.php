<?php

namespace App\Models\V1;

use App\Enums\V1\RecoveryKeyStatus;
use App\Models\V1\Traits\Encryptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RecoveryKey extends Model
{
    use HasFactory, Encryptable;

    protected $fillable = [
        'user_id',
        'recovery_code',
        'status'
    ];

    protected $encryptable = ['recovery_code'];

    protected $casts = [
        'status' => RecoveryKeyStatus::class,
    ];


    //generating random Recovery words
    public function generateRecoveryCodes(User $user)
    {
        
        //randomizing the dictionary words
        $recoveryArray = Arr::random(
            config('random_keys.recovery_codes'),
            config('random_keys.recovery_code_length')
        );

        //coverting to string
        $recoveryString = implode(" ", $recoveryArray);

        //Recovery Key Creation in DB
        $recoveryGeneration = RecoveryKey::create([
            'user_id' => $user->id,
            'recovery_code' => $recoveryString,
            'status' => RecoveryKeyStatus::Inactive,
        ]);

        return $recoveryGeneration;
        
    }


    //Dwonloading RecoveryWords
    public function downloadRecoveryWords(User $user)
    {

        $userRecoveryCodes = RecoveryKey::whereUserId($user->id)->orderBy('id','asc')->first();

        $userRecoveryCodes = $userRecoveryCodes->recovery_code;
        $data = [
            'words_array' => explode(' ',$userRecoveryCodes)
        ];

        return $data;
    }



    public function user()
    {
        $this->belongsTo(User::class, 'user_id');
    }
}