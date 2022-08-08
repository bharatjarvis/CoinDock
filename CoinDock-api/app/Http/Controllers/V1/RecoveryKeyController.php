<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CreateRecoveryKeyRequest;
use App\Http\Requests\V1\RecoveryKeyRequest;
use App\Http\Resources\V1\RecoveryCodeResource;
use App\Models\V1\{User, RecoveryKey};
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class RecoveryKeyController extends Controller
{
    public function random(User $user)
    {
        return response(
            [
                'results' => Arr::random(
                    range(1, config('random_keys.recovery.block_length')),
                    config('random_keys.recovery.test_block_length'),
                ),
            ],
            Response::HTTP_OK
        );
    }
    /**
     * Generating the recovery codes randomly.
     *
     * @return Response
     */
    public function create(User $user, CreateRecoveryKeyRequest $request)
    {

        $recoveryKey = RecoveryKey::store($user,$request);

        return response(
            [
                'message' => 'Recovery codes created successfully',
                'results' => [
                    'recovery_code' => new RecoveryCodeResource($recoveryKey),
                    'completed' => 3,
                ],
            ],
            Response::HTTP_OK
        );
    }


    public function download(User $user)
    {
        $recoveryKey = $user->recoveryKey()->latest()->first();

        $data = $recoveryKey->download();
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
                Response::HTTP_BAD_REQUEST
            );
        }

        if($recoveryKey->recoveryKeys($request)) {
            return response(
                [
                    'message' => 'Recovery codes matched successfully',
                    'result' => [
                        'completed' => 4,
                    ],
                ],
                Response::HTTP_OK
            );
        }
        $user->refresh();

        return response(
            [
                'error' => [
                    'message' => __("recovery-code.attempt-{$user->recovery_attempts}"),
                ],
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

}