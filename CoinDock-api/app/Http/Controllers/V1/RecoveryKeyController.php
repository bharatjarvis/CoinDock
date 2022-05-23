<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RecoveryKeyController extends Controller
{
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
