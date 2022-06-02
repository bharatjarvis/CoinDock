<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\Coin;
use App\Models\V1\User;
use App\Models\V1\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WalletController extends Controller
{
    public function addWallet(User $user, Request $request){
        $wallet = new Wallet();

        return $wallet->addWallet($user ,$request);
    }
}
