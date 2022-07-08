<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Coin extends Model
{
    use HasFactory;
    protected $fillable = ['coin_id', 'name', 'is_crypto', 'status', 'img_path', 'is_default'];


    public function wallets()
    {

        return $this->hasMany(Wallet::class);
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
    public function priceConversion($from, $to, $grouped)
    {
        $baseUrl = config('coinapi.coin.api_url');
        $currencyURL = $baseUrl . config('coinapi.coin.exchange_url');
        $cryptConversionURL = str_replace(['{from}', '{to}'], [$from, $to], $currencyURL);
        $response = Http::withHeaders(['X-CoinAPI-Key' => config('coinapi.coin.api_key')])->get($cryptConversionURL);
        $price = $response['rate'];
        return $grouped * $price;
    }

    //get the primary currency value
    public function getPrimaryCurrency()
    {
        //$from= 'BTC';
        $user = Auth::user();
        $grouped = $this->countCoins($user);
        $from = Coin::whereIsDefault(1)->first()?->coin_id;
        $to = Setting::whereUserId($user->id)->first()?->primary_currency;
        $data = $this->priceConversion($from, $to, $grouped);
        return $data;
    }


    //get secondary currency value
    public function getSecondaryCurrency()
    {
        $user = Auth::user();
        return $this->wallets()->whereUserId($user->id)
            ->whereCoinId($this->id)
            ->sum('balance');
    }

    //Coin Default Value
    public function defaultCoin()
    {
        $user = Auth::user();
        $grouped = $this->getSecondaryCurrency($user);
        $from = Setting::whereUserId($user->id)->first()?->primary_currency;
        $to = Coin::whereIsDefault(1)->first()?->coin_id;
        return $this->priceConversion($from, $to, $grouped);
    }
}
