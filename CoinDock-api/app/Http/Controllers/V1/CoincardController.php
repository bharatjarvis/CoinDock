<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\V1\User;
use App\Models\V1\{Wallet,Coin};


class CoincardController extends Controller
{
     public function coinCard(User $user){
        $data = new Coin();
        $logo = $data->logo($user);
        $numberOfCoins=$data->countCoins($user);
        $coinBTC=$data->coinDefault($user);
        $primaryCurrency = $data->getPrimaryCurrency($user);
        $secondaryCurrency = $data->getSecondaryCurrency($user);
        $coin = Coin::whereIsDefault(1)->first();
        return response([
                'message' => 'success',
                'result' => [
                        'logo' => $logo,
                        'coin-' . $coin->coin_id => $coinBTC,
                        'number_of_coins' =>$numberOfCoins,
                        'primary_currency' =>$primaryCurrency,
                        'secondary_currency' =>$secondaryCurrency,

                    ]
                ], 200);
     }
}

