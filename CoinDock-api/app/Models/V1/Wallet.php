<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\V1\{ User, Coin, Setting};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'coin_id',
        'user_id',
        'wallet_id',
        'balance'
    ];

    public function showPiechartData(User $user)
    {
        $wallets = Wallet::select(['coin_id', 'balance'])
            ->whereUserId($user->id)
            ->get()
            ->mapToGroups(function ($wallet) {
                return [$wallet->coin->name => $wallet->balance];
            })
            ->map(function ($e) {
                return $e->sum();
            })
            ->toArray();

        $coinDataAll = Coin::all();
        
        $userCoinConvertedPrimaryCurrencyData = [];
        foreach($wallets as $key1=>$value1){
            foreach($coinDataAll as $coinData){
                
                if(strtolower($coinData->name) == strtolower($key1)){
                    $userSettingPrimaryCurrency = Setting::whereUserId($user->id)->first()->primary_currency;

                    $cryptConversionBasePath = config('cryptohistoricaldata.coin_api.coin_api_url');
                    $cryptConversionApiKey = config('cryptohistoricaldata.coin_api.coin_api_key');
                    $cryptConversionBasePath = $cryptConversionBasePath."/exchangerate/$coinData->coin_id/$userSettingPrimaryCurrency?apikey=$cryptConversionApiKey";
                    $balanceInPrimaryCurrency = Http::get($cryptConversionBasePath);
                    //echo $balanceInPrimaryCurrency." ";

                    $totalPriceInPrimaryCurrency = $balanceInPrimaryCurrency['rate'] * $wallets[$key1];
                    $userCoinConvertedPrimaryCurrencyData[$coinData->coin_id] = $totalPriceInPrimaryCurrency;





                    
                    #echo $balanceInPrimaryCurrency." ";
                    // $cryptConversionId1 = str_replace('{id1}', $coinData->coin_id, $cryptConversionBasePath['piechartconvertor']);
                    // $cryptConversionId1 = $cryptConversionId1;
                    // $cryptConversionURL = str_replace('{id2}', $userSettingPrimaryCurrency, $cryptConversionId1);
                    // $balanceInPrimaryCurrency = Http::get($cryptConversionURL.);
                    // $totalPriceInPrimaryCurrency = $balanceInPrimaryCurrency['rate'] * $wallets[$key1];
                    // $userCoinConvertedPrimaryCurrencyData[$coinData->coin_id] = $totalPriceInPrimaryCurrency;
                }
            }
        }
       return $userCoinConvertedPrimaryCurrencyData;
    }


    public function showUserCoins(Wallet $wallet, User $user){

        $coinNames = Wallet::select('coin_id')
                    ->whereUserId($user->id)
                    ->get()
                    ->mapToGroups(function ($wallet) {
                        return [$wallet->coin->name];
                    })->toArray();
        

         // converting the 2-array to single array
         $singleArrayConversion = array();
         foreach($coinNames as $key => $value) {
             foreach($value as $key2 => $value2) {
                 $singleArrayConversion[$key2] = $value2;
             }
         }
        
        // removing the duplicates
        $singleArrayConversion = array_unique($singleArrayConversion);

        return ($singleArrayConversion);
        
        
    }



    public function showCoinRangeData(Request $request, User $user){
        $coinNameFromUser = strtolower($request->coin_name);
        $range = $request->range;

        $shortNameList = config('shortnames.shorted_coin_list');
        $shortNameCode = "";
        foreach ($shortNameList as $key => $value) {
            if ($coinNameFromUser === strtolower($key)) {
                $shortNameCode = $shortNameList[$key];
            }
        }
        
        $rangeList = config('cryptohistoricaldata');

        $userRequestedRangeLink =  $rangeList[$range];

        $userRequestedRangeLink = str_replace('{id}',$shortNameCode,$userRequestedRangeLink);

        $getHistoricalData = Http::get($userRequestedRangeLink);

        $getHistoricalData =  $getHistoricalData['Data']['Data'];

        $userCoinData = [];
        foreach($getHistoricalData as $data){
            $userCoinData[date("Y-m-d h:i:s",substr($data['time'],0,10))] = $data['close'];
        }
        return $userCoinData;
    }

    public function realtimeCoinHistoricalData(Request $request,User $user){


        // getting the coins associated with the users
        $coinNames = Wallet::select('coin_id')
                    ->whereUserId($user->id)
                    ->get()
                    ->mapToGroups(function ($wallet) {
                        return [$wallet->coin->name];
                    })->toArray();
         // converting the 2-array to single array
         $singleArrayConverstion = array();
         foreach($coinNames as $key => $value) {
             foreach($value as $key2 => $value2) {
                 $singleArrayConverstion[$key2] = $value2;
             }
         }
        // removing the duplicates
        $singleArrayConverstion = array_unique($singleArrayConverstion);
        //dd($singleArrayConverstion);

        $coinDataAll = Coin::all();
        // finding the code for coins
        $shortNames = [];
        foreach ($singleArrayConverstion as $singleArrayConverstionDataCoin) {
            foreach ($coinDataAll as $coinData) {
                if (strtolower($singleArrayConverstionDataCoin) === strtolower($coinData->name)) {
                    array_push($shortNames,$coinData->coin_id);
                }
            }
        }

        //return $shortNames;

        $cryptConversionBaseURL = config('cryptohistoricaldata.coin_api.coin_api_key');
        // $cryptConversionBasePath = $cryptConversionBaseURL."/exchangerate/$shortName/$userSettingPrimaryCurrency/history?period_id=?apikey=$cryptConversionApiKey";


        $finalDataDisplay = [];
        $realTimeDataForUserCoins = [];
        $rangeList = config('cryptohistoricaldata');

        $userRequestedRange =  $rangeList['daily'];

        foreach($shortNames as $shortName){

            $userRequestedRange = str_replace('{id}',$shortName,$userRequestedRange);
            $getHistoricalData = Http::get($userRequestedRange);            
            $getHistoricalData =  $getHistoricalData['Data']['Data'];
            foreach($getHistoricalData as $data){
                $finalDataDisplay[date("Y-m-d",substr($data['time'],0,10))] = $data['close'];
                
            }
            array_push($realTimeDataForUserCoins,[$shortName,$finalDataDisplay]);

        }
        return $realTimeDataForUserCoins;
   }


    public function coin(){
        return $this->belongsTo(Coin::class);
    }


}

