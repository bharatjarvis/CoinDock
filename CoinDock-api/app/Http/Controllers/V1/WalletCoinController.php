<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\{Wallet, User, Coin};
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Svg\Tag\Rect;

class WalletCoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // function to get pie chart values
    public function showPiechartData(User $user){
        $wallet = new Wallet();
        return $wallet->showPiechartData($user);
    }

    // function to display the coins of user
    public function showUserCoins(Wallet $wallet, User $user){
        return $wallet->showUserCoins($wallet,$user);
    }

    // function to display historical data for particular coins
    public function showCoinRangeData(Request $request, User $user){
        $wallet = new Wallet();
        return $wallet->showCoinRangeData($request,$user);
    }

    // function to display historical data of user coins
    public function realtimeCoinHistoricalData(Request $request,User $user){
        $wallet = new Wallet();
        return $wallet->realtimeCoinHistoricalData($request,$user);
    }

}