<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Composer\DependencyResolver\Request as DependencyResolverRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\V1\User;
use App\Models\V1\RecoveryKey;

class RecoveryKeyController extends Controller
{
    public  function recovery_keys(User $user , Request $request)
  {
      $user_recovery_code = RecoveryKey::where("user_id",$user->id)->first();
      $pass_array =($user_recovery_code->recovery_code);
     
      $pass_array=explode(" ",$pass_array);
      if($request->first == $pass_array[1]& $request->second == $pass_array[2] &
      $request->third == $pass_array[3] ){
          $required_user = User::whereId($user->id)->first();
          $required_user->status = 4;
      }
      else{
        return response([
            'Error' => 'Recovery codes did not match ',
        ],401);
    }
}
}