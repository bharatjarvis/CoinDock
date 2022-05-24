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
    //random keys generation
    public function random_numbers(){

        $array = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
 
        $random = Arr::random($array, 3);
        return $random;
        //info('return $random_numbers');
    }
}