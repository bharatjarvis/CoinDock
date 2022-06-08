<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\V1\User;
use App\Models\V1\{Wallet,Coin};
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function numberOfCoins(User $user){

        $data= Wallet::select(['coin_id',
                            'balance',
                            ])
                            ->whereUserId($user->id)
                            ->get();
        $grouped = $data->mapToGroups(function($wallet){
                            return [$wallet->coin->name => $wallet->balance];})
                        ->map(function ($row) {
                            return $row->sum();

        });
        return $grouped;
    }

}
