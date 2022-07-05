<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\{User, Signup};

class SignupController extends Controller
{
    public function info(User $user)
    {
        //$signUp = Signup::find($user->id);

        $signUp = Signup::whereUserId($user->id)->get()->first();

        $result = [
            'step_1_completed' => false,
            'step_2_completed' => false,
            'step_3_completed' => false,
        ];

        $stepCount = $signUp->step_count;

        if ($stepCount == 0) {
            return response(
                [
                    'message' => 'Signup not completed',
                    'results' => [
                        'step_details' => $result,
                    ],
                ],
                200,
            );
        }

        foreach (range(1, $stepCount) as $i) {
            $result["step_{$i}_completed"] = true;
        }

        return response(
            [
                'message' => 'Signup details',
                'results' => [
                    'step_details' => $result,
                ],
            ],
            200,
        );
    }
}