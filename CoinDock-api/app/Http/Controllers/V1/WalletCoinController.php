<?php

namespace App\Http\Controllers\V1;

use App\Enums\V1\TimePeriod;
use App\Http\Controllers\Controller;
use App\Models\V1\Coin;
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
        $result =  $user->showPieChartData($request);
        return response([
            'message'=>'success',
            'results'=>$result
        ],200);
    }
    
    public function pieChartFilter(){
        return response([
            'message' => 'success',
            'results' => ['coins','currency']
        ],200); 
    }

    public function showUserCoins(User $user){
        $result = $user->uniqueCoins()->pluck('coin_id');
        return response([
            'message' => 'success',
            'results' => $result
        ],200); 
    }

    public function realTimeGraphFilter(){ 
        return response([
            'message' => 'success',
            'results' => TimePeriod::getInstances()
        ],200); 
        
    }

    public function index(User $user, Request $request){
            return $user->index($request);
    } 


    public function coinConversion(){
        $coins = Coin::all()
            ->reduce(fn($carry, $coin) => $carry + [$coin->name=>$coin->coin_id], []);
        return response([
            'message' => 'success',
            'results' => $coins
        ],200); 
    }
       



}