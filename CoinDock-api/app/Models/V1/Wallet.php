<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\V1\CoinsController;
use Illuminate\Support\Facades\DB;

class Wallet extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'coin_id',
    //     'user_id',
    //     'wallet_id',
    //     'balance'
    // ];
    public function totalBTC(User $user)
    {
        $userWalletsDetails = Wallet::whereUserId($user->id)->orderBy('user_id', 'asc')->get();
        $balanceTotal = 0;
        foreach ($userWalletsDetails as $userWalletsDetail) {
            $balanceTotal += $userWalletsDetail->balance_USD;
        }

        $UsdToBtcConvertorApi = file_get_contents("https://min-api.cryptocompare.com/data/price?fsym=USD&tsyms=BTC");
        $decodeUSDtoBTCConvertorAPI = json_decode($UsdToBtcConvertorApi, true);
        $totalBtc = $balanceTotal * $decodeUSDtoBTCConvertorAPI['BTC'];

        return ["Total BTC"=> $totalBtc];
    }




    public function currencyConverter(User $user)
    {
        $userSetting = Setting::whereUserId($user->id)->first();
        
        $primaryCurrency = $userSetting->primary_currency;
        
        $primaryBalancePath = 'https://min-api.cryptocompare.com/data/price?fsym=BTC&tsyms=' . $primaryCurrency;
        
        $primaryBalance = file_get_contents($primaryBalancePath);
        
        $primaryBalanceDecode = json_decode($primaryBalance, true);
        
        $primaryBalance = $primaryBalanceDecode[$primaryCurrency];
        
        return [$primaryCurrency => $primaryBalance];
    }


    public function topPerformer(User $user, Wallet $wallet)
    {

        $shortNameList = config('shortnames.shorted_coin_list');

        $coinNames = Wallet::select('coin_id')
            ->whereUserId($user->id)
            ->get()
            ->mapToGroups(function ($wallet) {
                return [$wallet->coin->name];
            })->toArray();

        if($coinNames==NULL){
            return ["User Wallet Doesn't Exists"];
        }else{
            // converting the 2-array to single array
            $singleArrayConvertion = array();
            foreach ($coinNames as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    $singleArrayConvertion[$key2] = $value2;
                }
            }

            // removing the duplicates
            $singleArrayConvertion = array_unique($singleArrayConvertion);

            // getting the realtimevalue to find the top performer
            $topPerformerBalance = PHP_INT_MIN;
            $topPerformerCoin = "";
            $dataDisplay = [];
            foreach ($singleArrayConvertion as $singleArrayConvertionCoin) {
                foreach ($shortNameList as $key => $value) {
                    if ($singleArrayConvertionCoin === strtolower($key)) {
                        $shortNameCode = $shortNameList[$key];
                        $currentPrice = file_get_contents('https://min-api.cryptocompare.com/data/price?fsym=' . $shortNameCode . '&tsyms=USD');
                        $currentPriceDecode = json_decode($currentPrice, true);
                        if ($topPerformerBalance < $currentPriceDecode['USD']) {
                            $topPerformerBalance = $currentPriceDecode['USD'];
                            $topPerformerCoin = $shortNameCode;
                        }
                        $dataDisplay[$topPerformerCoin] = $topPerformerBalance;
                    }
                }
            }
            $result = [];
            $result[$topPerformerCoin] = $topPerformerBalance;
            return $result;
        }
    }




    public function lowPerformer(User $user, Wallet $wallet)
    {

        $shortNameList = config('shortnames.shorted_coin_list');

        $coinNames = Wallet::select('coin_id')
            ->whereUserId($user->id)
            ->get()
            ->mapToGroups(function ($wallet) {
                return [$wallet->coin->name];
            })->toArray();
            
        if($coinNames==NULL){
            return ["User Wallet Doesn't Exists"];
        }else{
        // converting the 2-array to single array
        $singleArrayConverstion = array();
        foreach ($coinNames as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $singleArrayConverstion[$key2] = $value2;
            }
        }
         // removing the duplicates
        $singleArrayConverstion = array_unique($singleArrayConverstion);

        // getting the realtimevalue to find the low performer
        $lowPerformerBalance = PHP_INT_MAX;
        $lowPerformerCoin = "";
        $dataDisplay = [];
        foreach ($singleArrayConverstion as $coinNameMatch) {
            foreach ($shortNameList as $key => $value) {
                if ($coinNameMatch === strtolower($key)) {
                    $shortNameCode = $shortNameList[$key];
                    $currentPrice = file_get_contents('https://min-api.cryptocompare.com/data/price?fsym=' . $shortNameCode . '&tsyms=USD');
                    $currentPriceDecode = json_decode($currentPrice, true);

                    if ($lowPerformerBalance > $currentPriceDecode['USD']) {
                        $lowPerformerBalance = $currentPriceDecode['USD'];
                        $lowPerformerCoin = $shortNameCode;
                    }
                    $dataDisplay[$lowPerformerCoin] = $lowPerformerBalance;
                }
            }
        }
        $result = [];
        $result[$lowPerformerCoin] = $lowPerformerBalance;
        return $result;
    }
}
    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }
    
}
