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

    public function showPieChartData(User $user,Request $request){
        return $user->showPieChartData($user, $request);
    }
    public function pieChartFilter(){
        $user = new User();
        return $user->pieChartFilter();
    }





    public function showUserCoins(User $user){
        $result = $user->showUserCoins($user);
        return response([
            'message'=>'success',
            'data'=>$result
        ],200); 
    }
    public function realTimeGraphFilter(){
        $user = new User();
        return $user->realTimeGraphFilter();
    }

    public function index(User $user, Request $request){
        return $user->index($user, $request);
    } 
       

}