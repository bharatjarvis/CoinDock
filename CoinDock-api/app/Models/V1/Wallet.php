<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'coin_id',
        'user_id',
        'wallet_id',
        'balance',
        'coins',
        'name'
    ];


    //wallet creation
    public function WalletCreate($userId, $walletId, $userCoinId, $coins, $balanceInUsd)
    {
        Wallet::create([
            'user_id' => $userId,
            'wallet_id' => $walletId,
            'coin_id' => $userCoinId,
            'coins' => $coins,
            'balance' => ($balanceInUsd * $coins)
        ]);

        return response([
            'message' => 'Wallet Added Successfully',

        ], 200);
    }


    //function to check whether the response is in json or not 
    public function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }


    //getting basePath for for checking Wallet Balance
    public function basePath($userCoinId, $walletId)
    {
        $userCoin = Coin::whereId($userCoinId)->first();
        $userCoinName = $userCoin->name;

        $coinList = config('wallet.base_url_lst');
        $coinKeys =  array_keys($coinList);

        $basePath = '';

        foreach ($coinKeys as $coin) {
            if ($userCoinName == $coin) {
                $basePath  = $coinList[$coin];
            }
        }

        return $basePath = str_replace('{id}', $walletId, $basePath);
    }





    //Converting every crypto currency into USD
    public function cryptoToUsd($coin)
    {
        $shortNames = config('shortnames.shorted_coin_list');
        $shortNamesKeys = array_keys($shortNames);
        foreach ($shortNamesKeys as $crypto) {
            if ($crypto == $coin) {
                $shortedCryptoName = $shortNames[$coin];
            }
        }

        $cryptConversionBasePath = config('exchange.cryp_exchange');
        $cryptConversionPath = str_replace('{id}', $shortedCryptoName, $cryptConversionBasePath);
        $balanceInUsd = Http::get($cryptConversionPath)['USD'];

        return $balanceInUsd;
    }








    //Fetching number of coins through the Response
    public function coins($response)
    {
        $responseArray = json_decode($response, true);
        $responseArrayKeys = array_keys($responseArray);


        foreach ($responseArrayKeys as $jsonKey) {
            if ($jsonKey == 'balance' || $jsonKey == 'result' || $jsonKey == 'data' || $jsonKey == 'result') {
                $coins = $responseArray[$jsonKey];

                return $coins;
            } elseif ($jsonKey == 'confirmed') {


                $confirmedResponse = json_decode($response, true);
                $confirmedResponse = json_encode($confirmedResponse['confirmed'], true);
                $confirmedResponseArray = json_decode($confirmedResponse, true);

                $coins = $confirmedResponseArray['nanoErgs'];
                return $coins;
            }
        }
    }

    
    //Adding Wallet for Particular User
    public function addWallet(User $user, Request $request)
    {
        $walletId = $request->wallet_id;

        $walletCheck = Wallet::whereWalletId($walletId)->first();

        if ($walletCheck) {
            return response([
                'message' => 'Wallet Already Added'
            ], 409);
        }


        $userCoin = $request->coin;


        $balanceInUsd = $this->cryptoToUsd($userCoin);

        $userCoinId = Coin::whereName($userCoin)->first();
        $userCoinId = $userCoinId->id;
        $basePath = $this->basePath($userCoinId, $walletId);

        $response = Http::get($basePath);

        if ($this->isJson($response)) {

            $coins = $this->coins($response);

            if (is_numeric($coins)) {
                return $this->WalletCreate($user->id, $walletId, $userCoinId, $coins, $balanceInUsd);
            } else {
                return response([
                    'message' => 'Wallet Cannot be Added'
                ], 404);
            }
        }


        return response([
            'message' => 'Wallet Cannot be Added'
        ], 404);
    }



}

