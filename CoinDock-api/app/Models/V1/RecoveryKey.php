<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\V1\RecoveryKeyRequest;

class RecoveryKey extends Model
{
    use HasFactory;

    protected $table = 'recovery_keys';

    public  function recoveryKeys(User $user, RecoveryKeyRequest $request)
    {
        
        $passArray = explode(" ", $this->recovery_code);

        $count = 0;
        
        $keyResponses = $request->key_response;
        
        foreach ($keyResponses as $key => $value) {
            if($passArray[$key-1] == $value) {
                $count++;
            }
        }

        if($count == count($keyResponses)) {

           // $this->update([
             //   'status' => RecoveryKeyStatus::Active
            //]);

            return response(
                [
                    'message' => 'Recovery codes matched successfully',
                    'result' => [
                        'completed' => 4
                    ],
                ], 
                200
            );
        }
       
        $attemptCount = $user->recovery_attemps;
      
        $maxAttemptCount = config('random_keys.recovery.attemps'); 

        if($attemptCount < $maxAttemptCount) {
            $user->update([
                'recovery_attemps' => $attemptCount + 1
            ]);
        }

        return response(
            [
                'error' => [
                    'message' => __("recovery-code.attempt-{$user->recovery_attemps}"),
                ]
            ], 
            400
        );
            
    }
    
}