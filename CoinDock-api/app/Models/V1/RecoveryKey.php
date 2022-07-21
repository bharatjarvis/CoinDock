<?php

namespace App\Models\V1;

use App\Enums\V1\RecoveryKeyStatus;
use App\Models\V1\Traits\Encryptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\V1\RecoveryKeyRequest;
use Illuminate\Http\Request;
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


    public static function GenerateRecoveryKeys(User $user)
    {
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
    //generating random Recovery words
    public static function store(User $user, Request $request)
    {

        if ($request->is_regenerate) {
            self::whereUserId($user->id)
                ->whereNot('status', RecoveryKeyStatus::Used)
                ->update(['status' => RecoveryKeyStatus::Used]);
        }

        $recoveryCode = self::whereUserId($user->id)
            ->whereStatus(RecoveryKeyStatus::Inactive)
            ->latest()
            ->first();

        if ($recoveryCode) {
            return $recoveryCode;
        }

        return self::GenerateRecoveryKeys($user);
    }


    //Downloading RecoveryWords
    public function download()
    {
        $userRecoveryCodes = $this->recovery_code;
        $data = [
            'words_array' => explode(' ', $userRecoveryCodes),
        ];

        // USER SUCCESSFULLY DOWNLOADED THE RECOVERY CODES  STEP:2
        $signup = $this->user->signup;
        if ($signup) {
            $signup->step_count += 1;
            $signup->save();
        }

        return $data;
    }

    public function recoveryKeys(RecoveryKeyRequest $request):bool
    {
        $recoveryCode = explode(" ", $this->recovery_code);

        $count = 0;

        $keyResponses = $request->key_response;

        foreach ($keyResponses as $key => $value) {
            if ($recoveryCode[$key - 1] == $value) {
                $count++;
            }
        }

        if ($count == count($keyResponses)) {
            $this->update([
                'status' => RecoveryKeyStatus::Active,
            ]);

            // USER SIGNUP STATUS RECOVERY CODES MATCHED SUCCESSFULLY - STEP:3
            $signup = $this->user->signup;
            if ($signup) {
                $signup->step_count += 1;
                if ($signup->step_count == 3) {
                    $signup->save();
                } else {
                    $signup->step_count = 3;
                    $signup->save();
                }
            }

            return true;
        }

        $attemptCount = $this->user->recovery_attempts;

        $maxAttemptCount = config('random_keys.recovery.attemps');

        if ($attemptCount < $maxAttemptCount) {
            $this->user->update([
                'recovery_attempts' => $attemptCount + 1,
            ]);
        }

        return false;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}