<?php

namespace App\Models\V1;

use App\Exceptions\ApiKeyException;
use App\Exceptions\WalletCreationException;
use App\Models\V1\{User, Coin};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
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
    public static function walletCreate($userId, $walletId, $userCoinId)
    {
        return self::create([
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
    public function coinCheck($coinShortCode, $coins)
    {
        $coinsString = (string)$coins;

        return (!Str::contains($coinsString, 'E') && Str::contains($coinsString, '.') || $coins == 0) ?
            $coins :
            $this->satoshiToCrypt($coinShortCode, $coinsString);
    }

    //converting Sathosis into Corresponding crypto coins
    public function satoshiToCrypt($coinShortCode, $sathosis)
    {
        $accetedCoins = config('assets.accepted_coins');

        return Arr::get($accetedCoins, $coinShortCode.'sats_to_crypt') * $sathosis;
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
        $coinId = $this->coin->coin_id;

        $coinList = config('assets.accepted_coins');

        $basePath = '';

        foreach ($coinList as $coinKey => $coinData) {
            if ($coinId == $coinKey) {
                $basePath = Arr::get($coinData, 'bal_path');
                if ($coinId == 'EXP' || $coinId == 'MOAC') {
                    return $basePath;
                }
            }
        }

        return str_replace('{id}', $this->wallet_id, $basePath);
    }

    //Converting every crypto currency into USD
    public function cryptoToUsd()
    {
        // $assetsConfig = config('assets.accepted_coins');
        // $assetShortName = $assetsConfig[$this->coin->coin_id]['coin_id'];

        $cryptConversionBasePath = config('coin.coin.api_url') . config('coin.coin.crypto_to_usd');
        $cryptConversionPath = str_replace('{id}', $this->coin->coin_id, $cryptConversionBasePath);

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
        $coinShortCode = $this->coin->coin_id;

        $responseArray = json_decode($response, true);
        $responseArrayKeys = array_keys($responseArray);

        switch ($coinShortCode) {
            case 'EXP'||'MOAC':
                return Arr::get($response,'balance');
            case 'AION':
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
                return $this->coinCheck($coinShortCode, $coins);
            } elseif ($jsonKey == 'confirmed') {


                $confirmedResponse = json_decode($response, true);
                $confirmedResponse = json_encode($confirmedResponse['confirmed'], true);
                $confirmedResponseArray = json_decode($confirmedResponse, true);

                $coins = $confirmedResponseArray['nanoErgs'];
                return $this->coinCheck($coinShortCode, $coins);
            }
        }
    }

    //Adding Wallet for Particular User
    public static function addWallet(User $user, Request $request)
    {
        try{
            DB::beginTransaction();
            $walletId = $request->wallet_id;

            $acceptedCoin = $request->coin;
            $coinId = Coin::whereCoinId($acceptedCoin)->first()?->id;

            $wallet = self::walletCreate($user->id, $walletId, $coinId);

            $balanceInUsd = $wallet->cryptoToUsd();
            $basePath = $wallet->basePath();

            $response = Http::get($basePath);

            if ($acceptedCoin == 'EXP' || $acceptedCoin == 'MOAC' ) {
                $response = Http::post($basePath, ['addr' => $walletId, 'options' => ['balance']]);
            }

            if ($wallet->isJson($response)) {
                $coins = $wallet->totalCoins($response);
                if (is_numeric($coins)) {
                    if ($acceptedCoin == 'EXP') {
                        return $wallet->update([
                            'balance' => $response['balanceUSD'],
                            'coins' => $coins
                        ]);
                    }
                    return $wallet->update(['balance' => $balanceInUsd * $coins, 'coins' => $coins]);
                }
            }
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            throw new WalletCreationException('Unable to add wallet, please check wallet Id and wallet address');
        }
        return true;
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coin_id', 'id');
    }
}