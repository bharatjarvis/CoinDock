<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RecoveryKeyRequest;
use App\Models\V1\User;
use App\Models\V1\RecoveryKey;
use Illuminate\Support\Arr;

class RecoveryKeyController extends Controller
{

    public function random()
    {    
        return response([
                'result'=> Arr::random(
                    range(1, config('random_keys.recovery.block_length')),
                    config('random_keys.recovery.test_block_length')
                )],
            200
        );
    }

    public function activate(User $user, RecoveryKeyRequest $request)
    {
      $recoveryKey = RecoveryKey::whereUserId($user->id)->latest()->first();
      
      return $recoveryKey->recoveryKeys($user, $request);
    }  
}