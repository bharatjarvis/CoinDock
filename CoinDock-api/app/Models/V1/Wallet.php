<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\V1\CoinsController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use phpDocumentor\Reflection\Types\Null_;

class Wallet extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'coin_id',
    //     'user_id',
    //     'wallet_id',
    //     'balance'
    // ];
    public function totalDefault(User $user)
    {
        $userWalletsDetails = Wallet::whereUserId($user->id)->orderBy('user_id', 'asc')->get();
        $balanceTotal = 0;
        foreach ($userWalletsDetails as $userWalletsDetail) {
            $balanceTotal += $userWalletsDetail->balance_USD;
        }

        $baseUrl = config('coin.coinapi.coinapiurl');
        $exchangeURL = $baseUrl . config('coin.coinapi.usdToBtc');
        $usdToBtC = Http::withHeaders(['X-CoinAPI-Key' => config('coin.coinapi.coinapikey')])->get($exchangeURL);
        $totalValue = $usdToBtC['rate'] * $balanceTotal;
        $coins = Coin::all();
        foreach ($coins as $coin) {
            if ($coin->is_default == 1) {
                return response([
                    'message' => 'success',
                    'result' => [
                        'total-' . $coin->coin_id => $totalValue,
                        'coin_id' => $coin->coin_id,
                        'coin_name' => $coin->name,
                        'img_url' => $coin->img_path

                    ]
                ], 200);
            }
        }
    }




    public function totalPrimaryCurrency(User $user)
    {
        $userSetting = Setting::whereUserId($user->id)->first();


        $primaryCurrency = $userSetting->primary_currency;
        $baseUrl = config('coin.coinapi.coinapiurl');
        $currencyURL = $baseUrl . config('coin.coinapi.primaryCurrency');
        $currency = str_replace('{id}', $primaryCurrency, $currencyURL);

        $primaryBalancePath = Http::withHeaders(['X-CoinAPI-Key' => config('coin.coinapi.coinapikey')])->get($currency);

        $balanceInUsd = Wallet::select('balance')
            ->whereUserId($user->id)
            ->get()
            ->mapToGroups(function ($wallet) {

                return ['balance' => $wallet->balance];
            })
            ->map(function ($e) {
                return $e->sum();
            });
        $userWalletsDetails = Wallet::whereUserId($user->id)->get();
        if ($userWalletsDetails->isEmpty()) {
            return ["User Wallet Doesn't Exists"];
        } else {

            $userBalanceInUsd = $balanceInUsd['balance'];
            $primaryBalance = $primaryBalancePath['rate'];
            $totalBalanceInPrimaryCurrency = ($primaryBalance * $userBalanceInUsd);
            return response([
                'message' => 'success',
                'result' => [
                    'total-' . $primaryCurrency => [
                        'priamary Currency' => $totalBalanceInPrimaryCurrency,

                    ]
                ]
            ], 200);
        }
    }


    public function topPerformer(User $user)
    {

        $userWalletCoins = Wallet::whereUserId($user->id)->get();

        if ($userWalletCoins->isEmpty()) {
            return response([
                'message' => 'User Wallet Not Found'
            ]);
        } else {
            $userCoins = [];
            foreach ($userWalletCoins as $userCoin) {
                $coin = Coin::select(['coin_id', 'name'])->whereId($userCoin->coin_id)->first();
                array_push($userCoins, $coin);
            }

            $baseUrl = config('coin.coinapi.coinapiurl');
            $currencyURL = $baseUrl . config('coin.coinapi.topPerformer');

            $topPerformerBal = PHP_INT_MIN;
            $coinName = Null;
            $shortName = Null;
            foreach ($userCoins as $coin) {
                $currency = str_replace('{id}', $coin->coin_id, $currencyURL);
                $primaryBalancePath = Http::withHeaders(['X-CoinAPI-Key' => config('coin.coinapi.coinapikey')])->get($currency);
                if($primaryBalancePath['rate'] > $topPerformerBal){
                    $topPerformerBal = $primaryBalancePath['rate'];
                    $shortName = $primaryBalancePath['asset_id_base'];
                    $coinName  = Coin::whereCoinId($shortName)->first()->name;

                }

            }
            return response([
                'message'=>'Success',
                'result'=>[
                    'Top-Performer'=>[
                        'coin_id'=> $shortName,
                        'name'=>$coinName,
                        'balance'=>$topPerformerBal
                    ]
                ]
            ],200);


        }
    }




    public function lowPerformer(User $user)
    {
        $userWalletCoins = Wallet::whereUserId($user->id)->get();

        if ($userWalletCoins->isEmpty()) {
            return response([
                'message' => 'User Wallet Not Found'
            ]);
        } else {
            $userCoins = [];
            foreach ($userWalletCoins as $userCoin) {
                $coin = Coin::select(['coin_id', 'name'])->whereId($userCoin->coin_id)->first();
                array_push($userCoins, $coin);
            }

            $baseUrl = config('coin.coinapi.coinapiurl');
            $currencyURL = $baseUrl . config('coin.coinapi.topPerformer');

            $lowPerformerBal = PHP_INT_MAX;
            $coinName = Null;
            $shortName = Null;
            foreach ($userCoins as $coin) {
                $currency = str_replace('{id}', $coin->coin_id, $currencyURL);
                $primaryBalancePath = Http::withHeaders(['X-CoinAPI-Key' => config('coin.coinapi.coinapikey')])->get($currency);
                if($primaryBalancePath['rate'] < $lowPerformerBal){
                    $lowPerformerBal = $primaryBalancePath['rate'];
                    $shortName = $primaryBalancePath['asset_id_base'];
                    $coinName  = Coin::whereCoinId($shortName)->first()->name;

                }

            }
            return response([
                'message'=>'Success',
                'result'=>[
                    'Low-Performer'=>[
                        'coin_id'=> $shortName,
                        'name'=>$coinName,
                        'balance'=>$lowPerformerBal
                    ]
                ]
            ],200);


        }
        
        
    }
    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }
}
