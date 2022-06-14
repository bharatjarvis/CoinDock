<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\{Wallet, User, Coin};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WalletCoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
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

        return $wallets;
    }



    public function show(Request $request,User $user){

        // getting the coins associated with the users
        $coinNames = Wallet::select('coin_id')
                    ->whereUserId($user->id)
                    ->get()
                    ->mapToGroups(function ($wallet) {
                        return [$wallet->coin->name];
                    })->toArray();

        
         // converting the 2-array to single array
         $newArray = array();
         foreach($coinNames as $key => $value) {
             foreach($value as $key2 => $value2) {
                 $newArray[$key2] = $value2;
             }
         }
        
        // removing the duplicates
        $newArray = array_unique($newArray);

        
         // getting dates and interval from user
        $days = $request->days;
        $interval = $request->interval;

    
        foreach($newArray as $coin){

            $coinName = $coin;
            $coinName = Str::lower($coinName);
            $coinName = str_replace (" ", "-", $coinName);
            
            
            $url = file_get_contents('https://api.coingecko.com/api/v3/coins/'.$coinName.'/market_chart?vs_currency=USD&days='.$days.'&interval='.$interval.'');
            $obj = json_decode($url , true);

            $obj = $obj['prices'];

            $arrayRange = [];

            foreach($obj as $o){

                $objValue = $o[0];

                $subStringDate = date("Y-m-d H:i:s",substr($objValue,0,10));
                
                $arrayAppend = [$subStringDate,$o[1]];

                $arrayRange = array_merge($arrayRange,$arrayAppend);
            }
            $arrayCoinName[$coinName] = $arrayRange;
        }
        return $arrayCoinName;

        // code to fetch the entire graphs in the coins table;

        // $coinNameStored = Coin::select('name')->get()->toArray();
        // $days = $request->days;
        // $interval = $request->range;
        // $arrayCoinName=[];

    }


}