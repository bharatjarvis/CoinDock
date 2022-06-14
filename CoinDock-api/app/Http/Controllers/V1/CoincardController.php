<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\V1\User;
use App\Models\V1\{Wallet,Coin};
use Illuminate\Support\Facades\DB;

class CoincardController extends Controller
{
    //Number of coins
    public function numberOfCoins(User $user){
        $count = new Coin();
        return $count->countCoins($user);
        
    }

    //Coin BTC
    public function coinBtc(Request $request, User $user){
        $change = new Coin();
        return $change->coinBtc($user , $request);


    }

    //Get default value of primarycurrency
    public function getPrimaryCurrency(User $user){
        $price= new Coin();
        return $price->getPrimaryCurrency($user);
    }

    //Primary Currency
    public function primaryCurrency(Request $request, User $user){
        $change = new Coin();
        return $change->exChange($request , $user);
     }

     //getSecondarCurrency
     public function getSecondaryCurrency(User $user){
        $price= new Coin();
        return $price->getSecondaryCurrency($user);
     }


     //SecondaryCurrency
    public function secondaryCurrency(Request $request, User $user){
        $change = new Coin();
        return $change->secondayCurrencyexChange($request , $user);
     }

    

    


}

