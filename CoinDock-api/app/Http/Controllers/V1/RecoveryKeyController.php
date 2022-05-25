<?php

namespace App\Http\Controllers\V1;


use App\Models\V1\RecoveryKey;
use App\Http\Controllers\Controller;
use App\Models\V1\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use PDF;

class RecoveryKeyController extends Controller
{
    /**
     * Generating the recovery codes randomly.
     *
     * @return \Illuminate\Http\Response
     */
    public function generateRecoveryCodes(User $user)
    {
        $recovery = new RecoveryKey();

        return response([
            'message' => 'Recovery codes created successfully',
            'results' => [
                'recovery_code' => $recovery->generateRecoveryCodes($user),
                //added a column accepted to recovery_key
                'completed' => 3
            ],
        ], 200);
 
    }

    public function downloadRecoveryWords(User $user)
    {

        $recovery = new RecoveryKey();

        $data = $recovery->downloadRecoveryWords($user);
        $pdf = PDF::loadview('myPDF', $data);
        $now = Carbon::now()->format('Y-m-d');

        return $pdf->download("recovery-words-{$now}.pdf");
    }

    //random keys generation
 
    public function recoveyKey()
    {
        $array = [1, 2, 3, 4, 5,6,7,8,9,10,11,12];
     
        $random = Arr::random($array,3);
        return $random;
        
    }
    
    public function random()
    {
        
        $random = Arr::random(config('random_keys.recovery_codes'),12);
        
    }

}