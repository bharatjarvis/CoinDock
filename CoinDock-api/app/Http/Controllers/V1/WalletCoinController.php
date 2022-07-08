<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ReturnUserCoinHistoricalDataRequest;
use App\Models\V1\User;
use Illuminate\Http\Request;

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

    public function index(User $user, ReturnUserCoinHistoricalDataRequest $request){
        return $user->index($user, $request);
    } 
       

}