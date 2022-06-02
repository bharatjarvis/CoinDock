<?php

namespace App\Http\Controllers\V1;


use App\Http\Controllers\Controller;
use App\Models\V1\RecoveryKey;
use App\Models\V1\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class RecoveryKeyController extends Controller
{
    /**
     * Generating the recovery codes randomly.
     *
     * @return Response
     */
    public function show(User $user)
    {
        $recovery = new RecoveryKey();

        return response([
            'message' => 'Recovery codes created successfully',
            'result' => [
                'recovery_code' => $recovery->show($user),
                'recovery_code_length'=>config('random_keys.recovery_code_length'),
                'completed' => 3
            ],
        ], 200);

    }

    public function download(User $user)
    {

        $recovery = new RecoveryKey();

        $data = $recovery->download($user);
        $pdf = Pdf::loadview('myPDF', $data);
        $now = Carbon::now()->format('Y-m-d');

        return $pdf->download("recovery-words-{$now}.pdf");
    }

    //random keys generation

    public function recoveyKey()
    {
        $array = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

        $random = Arr::random($array, 3);
        return $random;

    }

    public function random()
    {

        $random = Arr::random(config('random_keys.recovery_codes'), 12);

    }

}
