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
     public function coinCard(Request $request, User $user){
        $data = new Coin();
        $Logo = $data->logo($user);
        $NumberOfCoins=$data->countCoins($user);
        $coinBTC=$data->coinDefault($user);
        $PrimaryCurrency = $data->getPrimaryCurrency($user);
        $SecondaryCurrency = $data->getSecondaryCurrency($user);
        $coins = Coin::all();
        foreach ($coins as $coin) {
            if ($coin->is_default == 1) {
                return response([
                    'message' => 'success',
                    'result' => [
                        'Logo' => $Logo,
                        'Coin-' . $coin->coin_id => $coinBTC,
                        'Number of coins' =>$NumberOfCoins,
                        'Primary Currency' =>$PrimaryCurrency,
                        'Secondary Currency' =>$SecondaryCurrency,

                    ]
                ], 200);
     }

}
}
}