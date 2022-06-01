<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\Coin;
use App\Models\V1\User;
use App\Models\V1\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WalletController extends Controller
{
    public function store(User $user, Request $request)
    {
        $wallet_id = $request->wallet_id;
        $user_coin = $request->coin;

        $user_coin_id = Coin::whereName($user_coin)->first();
        $user_coin_id = $user_coin_id->id;

        $coinList = config('wallet.base_url_lst');
        $coinKeys =  array_keys($coinList);

        $basePath = '';

        foreach ($coinKeys as $coin) {
            if ($user_coin == $coin) {
                $basePath  = $coinList[$coin];
            }
        }

        $basePath = str_replace('{id}', $wallet_id, $basePath);

        $response = Http::get($basePath);


        //function to check whether the response is in json or not 
        function isJson($string)
        {
            json_decode($string);
            return (json_last_error() == JSON_ERROR_NONE);
        }

        if(isJson($response)){
            $response_array = json_decode($response,true);
            $response_array_keys = array_keys($response_array);

            foreach ($response_array_keys as $json_key){
                if($json_key == 'balance' || $json_key == 'result' || $json_key == 'result' || $json_key == 'result'){
                    $balance = $response_array[$json_key];

                    Wallet::create([
                        'user_id'=>1,
                        'wallet_id' =>$wallet_id,
                        'coin_id' =>$user_coin_id,
                        'balance' =>$balance
                    ]);
                    
                }
            }
        }
        
        




    }
}
