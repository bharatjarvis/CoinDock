<?php

namespace App\Http\Controllers\V1;


use App\Models\V1\RecoveryKey;
use App\Http\Controllers\Controller;
use App\Models\V1\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class RecoveryKeyController extends Controller
{
    //

    /**
     * Generating the recovery codes randomly.
     *
     * @return \Illuminate\Http\Response
     */
    public function generateRecoveryCodes(User $user, Request $request)
    {


        $recovery = new RecoveryKey();
        $obj = $recovery->generateRecoveryCodes($user,$request);

        return response([
            'message' => 'Recovery codes created successfully ',
            'result' => [
                'recovery_code' => $obj->recovery_code,
                'completed' => 3
            ],

        ], 200);

        
    }

    public function downloadRecoveryWords(User $user, Request $request)
    {

        $recovery = new RecoveryKey();

        $data = $recovery->downloadRecoveryWords($user,$request);
        $pdf = Pdf::loadview('myPDF', $data);
        $now = Carbon::now()->format('Y-m-d');

        return $pdf->download("recovery-words-{$now}.pdf");
    }
}
