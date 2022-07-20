<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Exceptions\ApiKeyException;
use Symfony\Component\HttpFoundation\Response;

class Coin extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'coin_id',
        'is_crypto',
        'status',
        'is_default',
        'img_path'
    ];


    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }


    //Conversions that we are accepting
    public static function currencyConversions()
    {
        return self::whereStatusAndIsCrypto(1,0)->orderBy('name','asc')->get();
    }


    //showing crypto coins that we are accepting
    public static function acceptedCryptoCoins()
    {
        return self::whereStatusAndIsCrypto(1,1)->orderBy('name','asc')->get();
    }


    //Number of Coins
    public function countCoins()
    {
        $user = Auth::user();
        return $this->wallets()->whereUserId($user->id)
            ->whereCoinId($this->id)
            ->sum('coins');
    }

    //Convertion
    public function priceConversion($from, $to, $grouped): float
    {
        $baseUrl = config('coin.coin.api_url');
        $currencyURL = $baseUrl . config('coin.coin.exchange_url');
        $cryptConversionURL = str_replace(['{from}', '{to}'], [$from, $to], $currencyURL);
        try {
            $response = Http::withHeaders(['X-CoinAPI-Key' => config('coin.coin.api_key')])->get($cryptConversionURL)['rate'];
        } catch (\Throwable $th) {

            throw new ApiKeyException('Server down, try again after some time', Response::HTTP_BAD_REQUEST);
        }
        return $response * $grouped;
    }

    //get the primary currency value
    public function getPrimaryCurrency(): float
    {
        //$from= 'BTC';
        $user = Auth::user();
        $grouped = $this->countCoins($user);
        $from = Coin::whereIsDefault(1)->first()?->coin_id;
        $to = $user->setting->whereUserId($user->id)->first()?->primary_currency;
        return $this->priceConversion($from, $to, $grouped);
    }


    //get secondary currency value
    public function getSecondaryCurrency(): float
    {
        $user = Auth::user();
        return $this->wallets()->whereUserId($user->id)
            ->whereCoinId($this->id)
            ->sum('balance');
    }

    //Coin Default Value
    public function defaultCoin(): float
    {
        $user = Auth::user();
        $grouped = $this->getSecondaryCurrency($user);
        $from = $user->setting->whereUserId($user->id)->first()?->primary_currency;
        $to = Coin::whereIsDefault(1)->first()?->coin_id;
        return $this->priceConversion($from, $to, $grouped);
    }
}
