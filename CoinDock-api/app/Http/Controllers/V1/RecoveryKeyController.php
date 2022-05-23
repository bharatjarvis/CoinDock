<?php

namespace App\Http\Controllers\V1;

use App\Enums\V1\recoveryKeyStatus;
use App\Models\V1\RecoveryKey;
use App\Http\Controllers\Controller;
use App\Models\V1\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RecoveryKeyController extends Controller
{
    //

    /**
     * Generating the recovery codes randomly.
     *
     * @return \Illuminate\Http\Response
     */
    public function recoveryCodes(User $user,Request $request)
    {
        //generating random dictionary words
        $recoveryString = Arr::random(config('random_keys.recovery_codes'),12);

        //coverting to string
        $recoveryString = implode(" ", $recoveryString);


        // Encrypting the Recovery String
        $recoveryStringFinal = bcrypt($recoveryString);


        //Recovery Key Creation in database
        RecoveryKey::create([
            'user_id' => $user->id,
            'recovery_code' => $recoveryStringFinal,
            'status' => recoveryKeyStatus::Inactive,
        ]);


        //variable to identify the completed page
        $completed = 3;

        return response([
            "recovery_code" =>$recoveryString,
            'completed'=>$completed

        ],201);
        
    }
}
