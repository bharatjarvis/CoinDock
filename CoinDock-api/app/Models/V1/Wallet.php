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
        'balance'
    ];

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

        $userCoinId = Coin::whereName($userCoin)->first();
        $userCoinId = $userCoinId->id;

        $coinList = config('wallet.base_url_lst');
        $coinKeys =  array_keys($coinList);

        $basePath = '';

        foreach ($coinKeys as $coin) {
            if ($userCoin == $coin) {
                $basePath  = $coinList[$coin];
            }
        }

        $basePath = str_replace('{id}', $walletId, $basePath);

        $response = Http::get($basePath);


        //function to check whether the response is in json or not 
        function isJson($string)
        {
            json_decode($string);
            return (json_last_error() == JSON_ERROR_NONE);
        }

        if (isJson($response)) {

            $responseArray = json_decode($response, true);
            $responseArrayKeys = array_keys($responseArray);


            foreach ($responseArrayKeys as $jsonKey) {
                if ($jsonKey == 'balance' || $jsonKey == 'result' || $jsonKey == 'data' || $jsonKey == 'result') {
                    $balance = $responseArray[$jsonKey];

                    Wallet::create([
                        'user_id' => $user->id,
                        'wallet_id' => $walletId,
                        'coin_id' => $userCoinId,
                        'balance' => $balance
                    ]);

                    return response([
                        'message' => 'Wallet Added Successfully',

                    ], 200);
                } elseif ($jsonKey == 'confirmed') {


                    $confirmedResponse = json_decode($response, true);
                    $confirmedResponse = json_encode($confirmedResponse['confirmed'], true);
                    $confirmedResponseArray = json_decode($confirmedResponse, true);

                    $balance = $confirmedResponseArray['nanoErgs'];

                    Wallet::create([
                        'user_id' => $user->id,
                        'wallet_id' => $walletId,
                        'coin_id' => $userCoinId,
                        'balance' => $balance
                    ]);

                    return response([
                        'message' => 'Wallet Added Successfully',

                    ], 200);
                }
            }
        }


        return response([
            'message' => 'Wallet Cannot be Added'
        ], 404);
    }
}
