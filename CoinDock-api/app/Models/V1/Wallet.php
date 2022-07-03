<?php

namespace App\Models\V1;
use Illuminate\Support\Arr;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\V1\{ User, Coin, Setting};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use function PHPUnit\Framework\isJson;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'coin_id',
        'user_id',
        'wallet_id',
        'balance'
    ];






    ///////////////////////////////////////////////////////////////////////////////////////

                    /* PIE chart Functionality */

    ///////////////////////////////////////////////////////////////////////////////////////

    public function showPiechartData(User $user, Request $request)
    {
        // getting the filter by condition from user
        $filterByCondition = $request->filterby;

        // getting the coin information
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
        // selecting the coin information 
        $coinDataAll = Coin::all();

        if($filterByCondition==NULL || $filterByCondition=='bycoins'){

            return response()->json([
                'user_name' => $user->first_name,
                'success' => TRUE,
                'message' => $message ?? 'Data Fetched Successfully',
                'exception' => $exception ?? Null,
                'error_code' => $error_code ?? Null,
                'result' => $wallets
                
            ], 200);

        }else{
            // array to store the coin information
            $userCoinConvertedPrimaryCurrencyData = [];
            // iterating and getting calculating the present market value based on the 
            // present data

            foreach($wallets as $key1=>$value1){
                foreach($coinDataAll as $coinData){
                    
                    if(strtolower($coinData->name) == strtolower($key1)){
                        // getting the primary currency of the user
                        $userSettingPrimaryCurrency = Setting::whereUserId($user->id)->first()->primary_currency;
                        // calling the base url from config files
                        $cryptoConversionBaseURL = config('cryptohistoricaldata.coin_api.coin_api_url').config('cryptohistoricaldata.coin_api.coin_exchange_url');
                        // replacement of coins from -> to
                        $cryptoConversionBaseURLId1Replace = str_replace('{id1}', $coinData->coin_id, $cryptoConversionBaseURL);
                        $cryptoConversionBaseURLId1Replace = $cryptoConversionBaseURLId1Replace;
                        $cryptoConversionBaseURLIdReplaced = str_replace('{id2}', $userSettingPrimaryCurrency, $cryptoConversionBaseURLId1Replace);
                        // passing the base url with authorization key
                        $cryptoConversionBaseURLwithHeaders = Http::withHeaders(['X-CoinAPI-Key'=>config('cryptohistoricaldata.coin_api.coin_api_key')])->get($cryptoConversionBaseURLIdReplaced);
                        // calculating the price based on the coins
                        $totalPriceInPrimaryCurrency = $cryptoConversionBaseURLwithHeaders['rate'] * $wallets[$key1];
                        // storing the information in the array.
                        $userCoinConvertedPrimaryCurrencyData[$coinData->coin_id] = $totalPriceInPrimaryCurrency;
                    
                    }
                }
            }
            // returing the information
            return response()->json([
                'user_name' => $user->first_name,
                'success' => TRUE,
                'message' => $message ?? 'Data Fetched Successfully',
                'exception' => $exception ?? Null,
                'error_code' => $error_code ?? Null,
                'result' => $userCoinConvertedPrimaryCurrencyData
                
            ], 200);
        // return $userCoinConvertedPrimaryCurrencyData;
        }
    }








    ///////////////////////////////////////////////////////////////////////////////////////

                    /* User Coins Functionality */

    ///////////////////////////////////////////////////////////////////////////////////////


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

        return response()->json([
            'user_name' => $user->first_name,
            'success' => TRUE,
            'message' => $message ?? 'Data Fetched Successfully',
            'exception' => $exception ?? Null,
            'error_code' => $error_code ?? Null,
            'result' => $singleArrayConversion
            
        ], 200);

        
        
    }


    ///////////////////////////////////////////////////////////////////////////////////////

                    /* Real Time Coins Historical Data for a particular coin Functionality */

    ///////////////////////////////////////////////////////////////////////////////////////



    public function displaySingleCoinHistoricalData(Request $request, User $user){
        $coinNameFromUser = $request->coin_name;
        $range = $request->range;
        // selecting the coin information 
        $coinDataAll = Coin::where('name','=',$coinNameFromUser)->get();
        $coinNameURLSend = $coinDataAll[0]['coin_id'];

        $end_date = Carbon::now()->format('Y-m-d');
        $end_date = $end_date."T".Carbon::now()->format('H:i:m');
        
        $realTimeDataDisplay = [];

        if($range=="weekly"){
            $range = '7DAY';
            $start_date = Carbon::now()->subYear(1);
            $start_date  = str_replace(' ','T',$start_date);
            
            $cryptoConversionBaseURL = config('cryptohistoricaldata.coin_api.coin_api_url').config('cryptohistoricaldata.coin_api.coin_realtime_url');

            $cryptoConversionBaseURLCoin1Replace = str_replace('{coin1}', $coinNameURLSend, $cryptoConversionBaseURL);
            $cryptoConversionBaseURLCoin1Replaced = $cryptoConversionBaseURLCoin1Replace;

            $cryptoConversionBaseURLRangeReplace = str_replace('{range}', $range, $cryptoConversionBaseURLCoin1Replaced);
            $cryptoConversionBaseURLRangeReplaced = $cryptoConversionBaseURLRangeReplace;

            $cryptoConversionBaseURLStartDateReplace = str_replace('{start_date}', $start_date, $cryptoConversionBaseURLRangeReplaced);
            $cryptoConversionBaseURLStartDateReplaced = $cryptoConversionBaseURLStartDateReplace;

            $cryptoConversionBaseURLwithAllIdsReplaced = str_replace('{end_date}', $end_date, $cryptoConversionBaseURLStartDateReplaced);

            $cryptoConversionBaseURLwithAllIdsReplacedResponse = Http::withHeaders(['X-CoinAPI-Key'=>config('cryptohistoricaldata.coin_api.coin_api_key')])->get($cryptoConversionBaseURLwithAllIdsReplaced);
            
            $cryptoConversionBaseURLwithAllIdsReplacedResponse = json_decode($cryptoConversionBaseURLwithAllIdsReplacedResponse);
            
            foreach($cryptoConversionBaseURLwithAllIdsReplacedResponse as $response){
                array_push($realTimeDataDisplay,[
                    'date'=>$response->time_period_end,
                    'price'=>$response->rate_close
                ]);
            }
            // $realTimeDataDisplay[$coinNameURLSend] = [$cryptoConversionBaseURLwithAllIdsReplacedResponse['time_period_end'],$cryptoConversionBaseURLwithAllIdsReplacedResponse['rate_close']];

            return response([
                'message'=>'success',
                'result'=>[
                    'coin'=>$coinNameFromUser,
                    'data'=>$realTimeDataDisplay
                ]
                
            ],200);

        }
        if($range=="monthly"){
            
            $range = '10DAY';
            $start_date = Carbon::now()->subYear(1);
            $start_date  = str_replace(' ','T',$start_date);
            
            $cryptoConversionBaseURL = config('cryptohistoricaldata.coin_api.coin_api_url').config('cryptohistoricaldata.coin_api.coin_realtime_url');

            $cryptoConversionBaseURLCoin1Replace = str_replace('{coin1}', $coinNameURLSend, $cryptoConversionBaseURL);
            $cryptoConversionBaseURLCoin1Replaced = $cryptoConversionBaseURLCoin1Replace;

            $cryptoConversionBaseURLRangeReplace = str_replace('{range}', $range, $cryptoConversionBaseURLCoin1Replaced);
            $cryptoConversionBaseURLRangeReplaced = $cryptoConversionBaseURLRangeReplace;

            $cryptoConversionBaseURLStartDateReplace = str_replace('{start_date}', $start_date, $cryptoConversionBaseURLRangeReplaced);
            $cryptoConversionBaseURLStartDateReplaced = $cryptoConversionBaseURLStartDateReplace;

            $cryptoConversionBaseURLwithAllIdsReplaced = str_replace('{end_date}', $end_date, $cryptoConversionBaseURLStartDateReplaced);

            $cryptoConversionBaseURLwithAllIdsReplacedResponse = Http::withHeaders(['X-CoinAPI-Key'=>config('cryptohistoricaldata.coin_api.coin_api_key')])->get($cryptoConversionBaseURLwithAllIdsReplaced);
            
            $cryptoConversionBaseURLwithAllIdsReplacedResponse = json_decode($cryptoConversionBaseURLwithAllIdsReplacedResponse);

            $priceArrayList = [];
            foreach($cryptoConversionBaseURLwithAllIdsReplacedResponse as $response){
                array_push($priceArrayList,$response->rate_close);
            }

            $priceArraySum = [];
            $sum = 0;
            $count = 0;
            for($i=1;$i<count($priceArrayList);$i++){
                $count=$i+1;
                $sum = $sum + $priceArrayList[$i];
                if($i%3==0){
                    array_push($priceArraySum,$sum/3);
                    $sum = 0;
                }
            }
            //return $priceArraySum;

            $everyMonth = [];
            $endDate = Carbon::now();
            $startDate = Carbon::now()->subYear(1);
            for($i=0;$i<=count($priceArraySum)-1;$i++){
                $startDate->addMonths(1);
                array_push($everyMonth,$startDate->format('Y-m-d'));

            }
            //return $everyMonth;

            $result = [];
            foreach($priceArraySum as $price){
                foreach($everyMonth as $month){
                    array_push($result,[
                        'date'=>$month,
                        'price'=>$price
                    ]);
                   
                }
                break;
            }
            return $result;
        }
        if($range=="year"){
            $range = '10DAY';
            $start_date = Carbon::now()->subYear(1);
            $start_date  = str_replace(' ','T',$start_date);
            
            $cryptoConversionBaseURL = config('cryptohistoricaldata.coin_api.coin_api_url').config('cryptohistoricaldata.coin_api.coin_realtime_url');

            $cryptoConversionBaseURLCoin1Replace = str_replace('{coin1}', $coinNameURLSend, $cryptoConversionBaseURL);
            $cryptoConversionBaseURLCoin1Replaced = $cryptoConversionBaseURLCoin1Replace;

            $cryptoConversionBaseURLRangeReplace = str_replace('{range}', $range, $cryptoConversionBaseURLCoin1Replaced);
            $cryptoConversionBaseURLRangeReplaced = $cryptoConversionBaseURLRangeReplace;

            $cryptoConversionBaseURLStartDateReplace = str_replace('{start_date}', $start_date, $cryptoConversionBaseURLRangeReplaced);
            $cryptoConversionBaseURLStartDateReplaced = $cryptoConversionBaseURLStartDateReplace;

            $cryptoConversionBaseURLwithAllIdsReplaced = str_replace('{end_date}', $end_date, $cryptoConversionBaseURLStartDateReplaced);

            $cryptoConversionBaseURLwithAllIdsReplacedResponse = Http::withHeaders(['X-CoinAPI-Key'=>config('cryptohistoricaldata.coin_api.coin_api_key')])->get($cryptoConversionBaseURLwithAllIdsReplaced);
            
            $cryptoConversionBaseURLwithAllIdsReplacedResponse = json_decode($cryptoConversionBaseURLwithAllIdsReplacedResponse);

            $priceArrayList = [];
            foreach($cryptoConversionBaseURLwithAllIdsReplacedResponse as $response){
                array_push($priceArrayList,$response->rate_close);
            }

            $priceArraySum = [];
            $sum = 0;
            $count = 0;
            for($i=1;$i<count($priceArrayList);$i++){
                $count=$i+1;
                $sum = $sum + $priceArrayList[$i];
                if($i%3==0){
                    array_push($priceArraySum,$sum/3);
                    $sum = 0;
                }
            }
            $res = 0;
            foreach($priceArraySum as $val){
                $res = $res + $val;
            }
            $avg = $res/12;
            $date = Carbon::now()->format('Y');
            return response([
                'message'=>'success',
                'result'=>[
                    'Year'=>$date,
                    'price'=>$avg
                ]
                
            ],200);

        }
    }


    ///////////////////////////////////////////////////////////////////////////////////////

                    /* Real Time Coins Historical Data for a every coin Functionality */

    ///////////////////////////////////////////////////////////////////////////////////////


    public function displayUserAllCoinHistoricalData(Request $request,User $user){

        // getting the coins associated with the users
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
    
        $coinDataAll = Coin::all();

        $coinShortNames = [];
        foreach($coinDataAll as $coin){
            foreach($singleArrayConversion as $filter)
            if(strtolower($coin->name)==strtolower($filter)){
                array_push($coinShortNames,$coin->coin_id);
            }
        }
        
        $newArrRes = [];
        $start_date = Carbon::now()->subDays(1);
        $start_date  = str_replace(' ','T',$start_date);
        foreach($coinShortNames as $coinShortName){
            $range = "1HRS";
            $cryptoConversionBaseURL = config('cryptohistoricaldata.coin_api.coin_api_url').config('cryptohistoricaldata.coin_api.coin_users_realtime_url');

            $cryptoConversionBaseURLCoin1Replace = str_replace('{coin1}', $coinShortName, $cryptoConversionBaseURL);
            $cryptoConversionBaseURLCoin1Replaced = $cryptoConversionBaseURLCoin1Replace;

            $cryptoConversionBaseURLRangeReplace = str_replace('{range}', $range, $cryptoConversionBaseURLCoin1Replaced);
            $cryptoConversionBaseURLRangeReplaced = $cryptoConversionBaseURLRangeReplace;

            $cryptoConversionBaseURLStartDateReplace = str_replace('{start_date}', $start_date, $cryptoConversionBaseURLRangeReplaced);
            $cryptoConversionBaseURLStartDateReplaced = $cryptoConversionBaseURLStartDateReplace;
            //return $cryptoConversionBaseURLStartDateReplaced;
            $cryptoConversionBaseURLwithAllIdsReplacedResponse = Http::withHeaders(['X-CoinAPI-Key'=>config('cryptohistoricaldata.coin_api.coin_api_key')])->get($cryptoConversionBaseURLStartDateReplaced);
            $cryptoConversionBaseURLwithAllIdsReplacedResponse = json_decode($cryptoConversionBaseURLwithAllIdsReplacedResponse);

            array_push($newArrRes,[$coinShortName,$cryptoConversionBaseURLwithAllIdsReplacedResponse]);

        }
        return response([
            'message'=>'success',
            'result'=>[
                'data'=>$newArrRes
            ]
            
        ],200);

    }






   public function realtimeCoinHistoricalDataFilter(){
    $filterArray = [];
    $cryptoConversionBaseURL = config('cryptohistoricaldata.coin_api.coin_api_url').config('cryptohistoricaldata.coin_api.coin_filter_url');
    $cryptoConversionBaseURLwithHeaders = Http::withHeaders(['X-CoinAPI-Key'=>config('cryptohistoricaldata.coin_api.coin_api_key')])->get($cryptoConversionBaseURL);
    $cryptoConversionBaseURLwithHeadersConvertedJsonDataAll  = json_decode($cryptoConversionBaseURLwithHeaders, true);
    foreach($cryptoConversionBaseURLwithHeadersConvertedJsonDataAll as $cryptoConversionBaseURLwithHeadersConvertedJsonData ){
        if($cryptoConversionBaseURLwithHeadersConvertedJsonData['unit_name']=='day'){
            array_push($filterArray,$cryptoConversionBaseURLwithHeadersConvertedJsonData['period_id']);
        }
    }
    return response()->json([
        'success' => TRUE,
        'message' => $message ?? 'Data Fetched Successfully',
        'exception' => $exception ?? Null,
        'error_code' => $error_code ?? Null,
        'result' => $filterArray
        
    ], 200);
   
   }

    // relationship
    public function coin(){
        return $this->belongsTo(Coin::class);
    }


}

