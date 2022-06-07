<?php

namespace App\Models\V1;

use App\Enums\V1\RecoveryKeyStatus;
use App\Models\V1\Traits\Encryptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\V1\RecoveryKeyRequest;
use Illuminate\Support\Arr;

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

    //Dwonloading RecoveryWords
    public function download(User $user)
    {
        $userRecoveryCodes = self::whereUserId($user->id)->latest()->first();

        $userRecoveryCodes = $userRecoveryCodes->recovery_code;
        $data = [
            'words_array' => explode(' ', $userRecoveryCodes),
        ];

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