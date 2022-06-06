<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\V1\{Coin,Wallet,User}; 
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Support\Facades\DB;
use PDO;

class WalletCoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {   
        $wallets = Wallet::select(['coin_id','balance'])
            ->whereUserId($user->id)
            ->get()
            ->mapToGroups(function($wallet) {
                return [$wallet->coin->name => $wallet->balance];
            })->map(function($e) {
                return  $e->sum();
            })->toArray();

        dd($wallets);
        return view('chart',['wallets' => [$wallets]]);
        
    }
}
