<?php

namespace App\Models\V1;

use App\Http\Requests\V1\AddWalletRequest;
use App\Http\Requests\V1\WalletRequest;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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
            'balance' => ($balanceInUsd*$coins)
        ]);
        return true;
    }

    //checking wheather the coin is float or int or scientific
    public function coinCheck($coin, $coins)
    {
        $coinsString = (string)$coins;
        if (!Str::contains($coinsString, 'E') && Str::contains($coinsString, '.')) {
            return $coins;
        } else {
            return $this->satoshiToCrypt($coin, $coinsString);
        }
    }

    //converting Sathosis into Corresponding crypto coins
    public function satoshiToCrypt($coin, $sathosis)
    {
        $satsToCoins = array_keys(config('assets.accepted_coins'));

        return ($satsToCoins[$coin]['sats_to_crypt'] * $sathosis);
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
        $userCoinName = Coin::whereId($userCoinId)->first()->name;

        $coinList = config('assets.accepted_coins');
        $coinKeys =  array_keys($coinList);

        $basePath = '';

        foreach ($coinKeys as $coin) {
            if ($userCoinName == $coin) {
                $basePath  = config('assets.accepted_coins');
                $basePath = $basePath[$coin]['bal_path'];
            }
        }

        return $basePath = str_replace('{id}', $walletId, $basePath);
    }

    //Converting every crypto currency into USD
    public function cryptoToUsd($coin)
    {
        $assetsConfig = config('assets.accepted_coins');
        $assetShortName = $assetsConfig[$coin]['coin_id'];

        $cryptConversionBasePath = config('assets.coin_api.base_path') . config('assets.coin_api.crypto_usd');
        $cryptConversionPath = str_replace('{id}', $assetShortName, $cryptConversionBasePath);
        $balanceInUsd = Http::withHeaders(['X-CoinAPI-Key' => config('assets.coin_api.key')])
            ->get($cryptConversionPath)['rate'];

        return $balanceInUsd;
    }

    //Fetching number of coins through the Response
    public function coins($response, $coin)
    {
        $responseArray = json_decode($response, true);
        $responseArrayKeys = array_keys($responseArray);

        foreach ($responseArrayKeys as $jsonKey) {
            if ($jsonKey == 'balance' || $jsonKey == 'data' || $jsonKey == 'result') {

                $coins = $responseArray[$jsonKey];
                return $this->coinCheck($coin, $coins);
            } elseif ($jsonKey == 'confirmed') {


                $confirmedResponse = json_decode($response, true);
                $confirmedResponse = json_encode($confirmedResponse['confirmed'], true);
                $confirmedResponseArray = json_decode($confirmedResponse, true);

                $coins = $confirmedResponseArray['nanoErgs'];
                return $this->coinCheck($coin, $coins);
            }
        }
    }

    //Adding Wallet for Particular User
    public function addWallet(User $user,Request $request)
    {
        $walletId = $request->wallet_id;
        $walletCheck = Wallet::whereWalletId($walletId)->first();

        if ($walletCheck) {
            return response([
                'message' => 'Wallet Already Added'
            ], Response::HTTP_CONFLICT);
        }

        $userCoin = $request->coin;
        $balanceInUsd = $this->cryptoToUsd($userCoin);

        $userCoinId = Coin::whereName($userCoin)->first()->id;

        $basePath = $this->basePath($userCoinId, $walletId);
        $response = Http::get($basePath);

        if ($this->isJson($response)) {
            $coins = $this->coins($response, $userCoin);
            if (is_numeric($coins)) {
                return $this->WalletCreate($user->id, $walletId, $userCoinId, $coins, $balanceInUsd);
            }
        }
        return false;
    }
}
