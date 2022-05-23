<?php

namespace App\Http\Controllers\V1;

use App\Enums\V1\RecoveryKeyStatus;
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

        $length = config('random_keys.recovery_code_length');
        $recoveryArray = Arr::random(config('random_keys.recovery_codes'),$length);

        //coverting to string
        $recoveryString = implode(" ", $recoveryArray);


        // // Encrypting the Recovery String
        // $recoveryStringFinal = bcrypt($recoveryString);


        //Recovery Key Creation in database
        RecoveryKey::create([
            'user_id' =>2 ,// $user->id,
            'recovery_code' => $recoveryString,
            'status' => RecoveryKeyStatus::Inactive,
        ]);


        //variable to identify the completed page
        $completed = 3;

        return response([
            'status' =>'Recovery codes created successfully ',
            'recovery_code' =>$recoveryString,
            'completed'=>$completed

        ],200);
        
    }
}
