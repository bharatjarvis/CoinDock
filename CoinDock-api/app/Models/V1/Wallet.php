<?php

namespace App\Models\V1;

use App\Exceptions\ApiKeyException;
use App\Models\V1\{ User, Coin};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class Wallet extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
        $this->create([
            'user_id' => $userId,
            'wallet_id' => $walletId,
            'coin_id' => $userCoinId,
            'coins' => $coins,
            'balance' => $balanceInUsd
        ]);
        return true;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


    //checking wheather the coin is float or int or scientific
    public function coinCheck($coin, $coins)
    {
        $coinsString = (string)$coins;
        if (!Str::contains($coinsString, 'E') && Str::contains($coinsString, '.') || $coins == 0) {
            return $coins;
        } else {
            return $this->satoshiToCrypt($coin, $coinsString);
        }
    }

    //converting Sathosis into Corresponding crypto coins
    public function satoshiToCrypt($coin, $sathosis)
    {
        $satsToCoins = config('assets.accepted_coins');

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
        $userCoinName = Coin::whereId($userCoinId)->first()?->name;

        $coinList = config('assets.accepted_coins');
        $coinKeys =  array_keys($coinList);

        $basePath = '';

        foreach ($coinKeys as $coin) {
            if ($userCoinName == $coin) {
                $basePath  = config('assets.accepted_coins');
                $basePath = $basePath[$coin]['bal_path'];
                if ($userCoinName == 'Expanse') {
                    return $basePath;
                }
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
        $response = Http::withHeaders(['X-CoinAPI-Key' => config('assets.coin_api.key')])
            ->get($cryptConversionPath)['rate'];

        if(!$response){
            throw new ApiKeyException('Server down, try again after some time',Response::HTTP_BAD_REQUEST);
        }
        return $response;
    }

    //Fetching number of coins through the Response
    public function totalCoins($response, $coin)
    {
        $responseArray = json_decode($response, true);
        $responseArrayKeys = array_keys($responseArray);

        if ($coin == 'Expanse') {
            return $response['balance'];
        }
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
    public function addWallet(User $user, Request $request)
    {
        $walletId = $request->wallet_id;

        $userCoin = $request->coin;
        $userCoinId = Coin::whereName($userCoin)->first()?->id;

        $balanceInUsd = $this->cryptoToUsd($userCoin);

        $basePath = $this->basePath($userCoinId, $walletId);
        $response = Http::get($basePath);

        if ($userCoin == 'Expanse') {
            $response = Http::post($basePath, ['addr' => $walletId, 'options' => ['balance']]);
        }

        if ($this->isJson($response)) {
            $coins = $this->totalCoins($response, $userCoin);
            if (is_numeric($coins)) {
                if ($userCoin == 'Expanse') {
                    return $this->WalletCreate($user->id, $walletId, $userCoinId, $coins, $response['balanceUSD']);
                }
                return $this->WalletCreate($user->id, $walletId, $userCoinId, $coins, $balanceInUsd*$coins);
            }
        }
        return true;
    }

    public function coin()
    {
        return $this->belongsTo('App\Models\V1\Coin', 'coin_id', 'id');
    }
}
