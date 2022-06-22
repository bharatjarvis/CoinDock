<?php

namespace App\Models\V1;

use App\Enums\V1\RecoveryKeyStatus;
use App\Models\V1\Traits\Encryptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\V1\RecoveryKeyRequest;
use App\Models\V1\Signup;
use Illuminate\Support\Arr;
use Laminas\Code\Reflection\FunctionReflection;

class RecoveryKey extends Model
{
    use HasFactory, Encryptable;

    protected $fillable = ['user_id', 'recovery_code', 'status'];

    protected $encryptable = ['recovery_code'];

    protected $table = 'recovery_keys';

    protected $casts = [
        'status' => RecoveryKeyStatus::class,
    ];

    //generating random Recovery words
    public function store(User $user)
    {
        $recoveryCode = $this->whereUserId($user->id)
            ->whereStatus(RecoveryKeyStatus::Inactive)
            ->latest()
            ->first();
            
        if ($recoveryCode) {
            return $recoveryCode;
        }

        //randomizing the dictionary words
        $recoveryArray = Arr::random(
            config('random_keys.recovery_codes'),
            config('random_keys.recovery.block_length'),
        );

        //coverting to string
        $recoveryString = implode(" ", $recoveryArray);

        //Recovery Key Creation in DB
        $recoveryGeneration = self::create([
            'user_id' => $user->id,
            'recovery_code' => $recoveryString,
            'status' => RecoveryKeyStatus::Inactive,
        ]);

       
        

        return $recoveryGeneration;
    }



    //Reg-generarion of recovery-codes
    public function reGenerateRecoveryKeys(User $user){
        
        $recovery = RecoveryKey::whereUserId($user->id)->first();
        //randomizing the dictionary words
        $recoveryArray = Arr::random(
            config('random_keys.recovery_codes'),
            config('random_keys.recovery.block_length'),
        );

        //coverting to string
        $recoveryString = implode(" ", $recoveryArray);

        $recovery->update(['recovery_code'=>$recoveryString]);
        return $recovery;
    }


    //Downloading RecoveryWords
    public function download(User $user)
    {
        $userRecoveryCodes = self::whereUserId($user->id)->latest()->first();

        $userRecoveryCodes = $userRecoveryCodes->recovery_code;
        $data = [
            'words_array' => explode(' ', $userRecoveryCodes),
        ];
        
        // USER SUCCESSFULLY DOWNLOADED THE RECOVERY CODES  STEP:2
        $signup = Signup::whereUserId($user->id)->get()->first();
        if($signup){
            $signup->step_count+=1;
            $signup->save();
        }

        return $data;
    }

    public function recoveryKeys(User $user, RecoveryKeyRequest $request)
    {
        $passArray = explode(" ", $this->recovery_code);

        $count = 0;

        $keyResponses = $request->key_response;

        foreach ($keyResponses as $key => $value) {
            if ($passArray[$key - 1] == $value) {
                $count++;
            }
        }

        if ($count == count($keyResponses)) {
            $this->update([
                'status' => RecoveryKeyStatus::Active,
            ]);

            // USER SIGNUP STATUS RECOVERY CODES MATCHED SUCCESSFULLY - STEP:3
            $signup = Signup::whereUserId($user->id)->get()->first();
            if($signup){
                $signup->step_count+=1;
                if($signup->step_count==3){
                    $signup->save();
                }else{
                    $signup->step_count = 3;
                    $signup->save();
                }
                
            }

            return response(
                [
                    'message' => 'Recovery codes matched successfully',
                    'result' => [
                        'completed' => 4,
                    ],
                ],
                200,
            );
        }



        $attemptCount = $user->recovery_attempts;

        $maxAttemptCount = config('random_keys.recovery.attemps');

        if ($attemptCount < $maxAttemptCount) {
            $user->update([
                'recovery_attempts' => $attemptCount + 1,
            ]);
        }

        return response(
            [
                'error' => [
                    'message' => __("recovery-code.attempt-{$user->recovery_attempts}"),
                ],
            ],
            400,
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}