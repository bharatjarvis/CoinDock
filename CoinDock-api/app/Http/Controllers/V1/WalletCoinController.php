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
    public function showPiechartData(User $user,Request $request){
        $wallet = new Wallet();
        return $wallet->showPiechartData($user, $request);
    }

    // function to display the coins of user
    public function showUserCoins(User $user){
        $wallet = new Wallet();
        return $wallet->showUserCoins($user);
    }

    // function to display historical data for particular coins
    public function displaySingleCoinHistoricalData(Request $request, User $user){
        $wallet = new Wallet();
        return $wallet->displaySingleCoinHistoricalData($request,$user);
    }

    // function to display historical data of user coins
    public function displayUserAllCoinHistoricalData(Request $request,User $user){
        $wallet = new Wallet();
        return $wallet->displayUserAllCoinHistoricalData($request,$user);
    }

    public function realtimeCoinHistoricalDataFilter(){
        $wallet = new Wallet();
        return $wallet->realtimeCoinHistoricalDataFilter();
    }

}