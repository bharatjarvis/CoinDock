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
    public function totalBtc(User $user)
    {
        $userwallets = Wallet::whereUserId($user->id)->orderBy('user_id', 'asc')->get();
        $balanceTotal = 0;
        foreach ($userwallets as $user) {
            $balanceTotal += $user->balance_USD;
        }

        $url = file_get_contents("https://min-api.cryptocompare.com/data/price?fsym=USD&tsyms=BTC");
        $obj = json_decode($url, true);
        $totalBtc = $balanceTotal * $obj['BTC'];

        return $totalBtc;
    }



    public function currencyConverter(User $user)
    {
        $userSetting = Setting::whereUserId($user->id)->first();
        $primaryCurrency = $userSetting->primary_currency;
        $totalBtc = $this->totalBtc($user);
        $primaryBalancePath = 'https://min-api.cryptocompare.com/data/price?fsym=BTC&tsyms=' . $primaryCurrency;
        $primaryBalance = file_get_contents($primaryBalancePath);
        $obj = json_decode($primaryBalance, true);
        $primaryBalance = $obj[$primaryCurrency];
        return $primaryBalance;
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


        // converting the 2-array to single array
        $newArray = array();
        foreach ($coinNames as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $newArray[$key2] = $value2;
            }
        }

        // removing the duplicates
        $newArray = array_unique($newArray);

        // getting the realtimevalue to find the top performer
        $topPerformerBalance = PHP_INT_MIN;
        $topPerformerCoin = "";
        $dataDisplay = [];
        foreach ($newArray as $coinNameMatch) {
            foreach ($shortNameList as $key => $value) {
                if ($coinNameMatch === strtolower($key)) {
                    $shortNameCode = $shortNameList[$key];
                    $currentPrice = file_get_contents('https://min-api.cryptocompare.com/data/price?fsym=' . $shortNameCode . '&tsyms=USD');
                    $obj = json_decode($currentPrice, true);
                    if ($topPerformerBalance < $obj['USD']) {
                        $topPerformerBalance = $obj['USD'];
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




    public function lowPerformer(User $user, Wallet $wallet)
    {

        $shortNameList = config('shortnames.shorted_coin_list');

        $coinNames = Wallet::select('coin_id')
            ->whereUserId($user->id)
            ->get()
            ->mapToGroups(function ($wallet) {
                return [$wallet->coin->name];
            })->toArray();


        // converting the 2-array to single array
        $newArray = array();
        foreach ($coinNames as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $newArray[$key2] = $value2;
            }
        }

        // removing the duplicates
        $newArray = array_unique($newArray);

        // getting the realtimevalue to find the low performer
        $lowPerformerBalance = PHP_INT_MAX;
        $lowPerformerCoin = "";
        $dataDisplay = [];
        foreach ($newArray as $coinNameMatch) {
            foreach ($shortNameList as $key => $value) {
                if ($coinNameMatch === strtolower($key)) {
                    $shortNameCode = $shortNameList[$key];
                    $currentPrice = file_get_contents('https://min-api.cryptocompare.com/data/price?fsym=' . $shortNameCode . '&tsyms=USD');
                    $obj = json_decode($currentPrice, true);
                    if ($lowPerformerBalance > $obj['USD']) {
                        $lowPerformerBalance = $obj['USD'];
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
    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }
}
