<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;

use App\Http\Requests\V1\RecoveryKeyRequest;
use App\Http\Resources\V1\RecoveryCodeResource;
use App\Models\V1\{User, RecoveryKey};
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class RecoveryKeyController extends Controller
{
    public function random()
    {
        return response(
            [
                'result' => Arr::random(
                    range(1, config('random_keys.recovery.block_length')),
                    config('random_keys.recovery.test_block_length'),
                ),
            ],
            200,
        );
    }
    /**
     * Generating the recovery codes randomly.
     *
     * @return Response
     */
    public function create(User $user)
    {
        $recovery = new RecoveryKey();

        $recoveryKey = $recovery->store($user);
        return response(
            [
                'message' => 'Recovery codes created successfully',
                'results' => [
                    'recovery_code' => new RecoveryCodeResource($recoveryKey),
                    'completed' => 3,
                ],
            ],
            200,
        );
    }



    public function reGenerateRecoveryKeys(User $user){

        $recovery = new RecoveryKey();

        $recoveryKeys = $recovery->reGenerateRecoveryKeys($user);

        return response(
            [
                'message' => 'Recovery codes Re-generated successfully',
                'results' => [
                    'recovery_code' => new RecoveryCodeResource($recoveryKeys),
                    'completed' => 3,
                ],
            ],
            200,
        );
        

    }


    
    public function download(User $user)
    {
        $recovery = new RecoveryKey();

        $data = $recovery->download($user);
        $pdf = Pdf::loadview('myPDF', $data);
        $now = Carbon::now()->format('Y-m-d');

        return $pdf->download("recovery-words-{$now}.pdf");
    }

    public function activate(User $user, RecoveryKeyRequest $request)
    {
        $recoveryKey = $user
            ->recoveryKeys()
            ->latest()
            ->first();

        if (!$recoveryKey) {
            return response(
                [
                    'message' => 'Recovery codes missing',
                ],
                400,
            );
        }

        return $recoveryKey->recoveryKeys($user, $request);
    }
}