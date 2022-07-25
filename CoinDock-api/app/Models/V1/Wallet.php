<?php

namespace App\Models\V1;

use App\Exceptions\ApiKeyException;
use App\Models\V1\{User, Coin};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
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
    public function walletCreate($userId, $walletId, $userCoinId)
    {
        return $this->create([
            'user_id' => $userId,
            'wallet_id' => $walletId,
            'coin_id' => $userCoinId,
        ]);
    }

    public function user()
    {
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

        return Arr::get($satsToCoins, $coin.'sats_to_crypt') * $sathosis;
    }

    //function to check whether the response is in json or not
    public function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    //getting basePath for for checking Wallet Balance
    public function basePath()
    {
        $coinName = $this->coin->name;

        $coinList = config('assets.accepted_coins');

        $basePath = '';

        foreach ($coinList as $coinKey => $coinData) {
            if ($coinName == $coinKey) {
                $basePath = Arr::get($coinData, 'bal_path');
                if ($coinName == 'Expanse' || $coinName == 'MOAC') {
                    return $basePath;
                }
            }
        }

        return str_replace('{id}', $this->wallet_id, $basePath);
    }

    //Converting every crypto currency into USD
    public function cryptoToUsd()
    {
        $assetsConfig = config('assets.accepted_coins');
        $assetShortName = $assetsConfig[$this->coin->name]['coin_id'];

        $cryptConversionBasePath = config('coin.coin.api_url') . config('coin.coin.crypto_to_usd');
        $cryptConversionPath = str_replace('{id}', $assetShortName, $cryptConversionBasePath);

        try {
            $response = Http::withHeaders(['X-CoinAPI-Key' => config('coin.coin.api_key')])
                ->get($cryptConversionPath)['rate'];
        } catch (\Throwable $th) {
            throw new ApiKeyException('Server down, try again after some time', Response::HTTP_BAD_REQUEST);
        }

        return $response;
    }

    //Fetching number of coins through the Response
    public function totalCoins($response)
    {
        $coin = $this->coin->name;

        $responseArray = json_decode($response, true);
        $responseArrayKeys = array_keys($responseArray);

        switch ($coin) {
            case 'Expanse'||'MOAC':
                return Arr::get($response,'balance');
            case 'Aion':
                return Arr::get(Arr::get(Arr::get($response,'content'),0),'balance');
            case 'PLSR':
                return Arr::get(Arr::get(Arr::get($response,'data'),2),4);
            case 'NEOX':
                return Arr::get(Arr::get(Arr::get($response,'data'),1),4);
            default:
                break;
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
    public static function addWallet(User $user, Request $request)
    {
        $walletId = $request->wallet_id;

        $userCoin = $request->coin;
        $userCoinId = Coin::whereName($userCoin)->first()?->id;

        $wallet = self::walletCreate($user->id, $walletId, $userCoinId);

        $balanceInUsd = $wallet->cryptoToUsd();
        $basePath = $wallet->basePath();

        $response = Http::get($basePath);

        if ($userCoin == 'Expanse') {
            $response = Http::post($basePath, ['addr' => $walletId, 'options' => ['balance']]);
        } elseif ($userCoin == 'MOAC') {
            $response = Http::post($basePath, ['addr' => $walletId, 'options' => ['balance']]);
        }

        if ($wallet->isJson($response)) {
            $coins = $wallet->totalCoins($response);
            if (is_numeric($coins)) {
                if ($userCoin == 'Expanse') {
                    return $wallet->update([
                        'balance' => $response['balanceUSD'],
                        'coins' => $coins
                    ]);
                }
                return $wallet->update(['balance' => $balanceInUsd * $coins, 'coins' => $coins]);
            }
        }
        return true;
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coin_id', 'id');
    }
}
