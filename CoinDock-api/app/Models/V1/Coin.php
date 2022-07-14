<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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

    public function wallets(){
        return $this->hasMany(Wallet::class);
    }

    public function acceptedAssets(){
        $acceptedAssets = $this::whereStatus(1)->get();
        return $acceptedAssets;
    }

    //Conversions that we are accepting
    public function currencyConversions(){
        $acceptedConversions = $this::whereStatus(1)->whereIsCrypto(0)->get();
        return $acceptedConversions;
    }

    //showing cruto coins that we are accepting
   public function acceptedCryptoCoins(){
        $acceptedCryptoCoins = $this::whereStatus(1)->whereIsCrypto(1)->get();
        return $acceptedCryptoCoins;
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
    public function priceConversion($from, $to, $grouped):float
    {
        $baseUrl = config('coinapi.coin.api_url');
        $currencyURL = $baseUrl . config('coinapi.coin.exchange_url');
        $cryptConversionURL = str_replace(['{from}', '{to}'], [$from, $to], $currencyURL);
        $response = Http::withHeaders(['X-CoinAPI-Key' => config('coinapi.coin.api_key')])->get($cryptConversionURL);
        return $response['rate'] * $grouped;
    }

    //get the primary currency value
    public function getPrimaryCurrency():float
    {
        //$from= 'BTC';
        $user = Auth::user();
        $grouped = $this->countCoins($user);
        $from = Coin::whereIsDefault(1)->first()?->coin_id;
        $to = $user->setting->whereUserId($user->id)->first()?->primary_currency;
        return $this->priceConversion($from, $to, $grouped);
    }


    //get secondary currency value
    public function getSecondaryCurrency():float
    {
        $user = Auth::user();
        return $this->wallets()->whereUserId($user->id)
            ->whereCoinId($this->id)
            ->sum('balance');
    }

    //Coin Default Value
    public function defaultCoin():float
    {
        $user = Auth::user();
        $grouped = $this->getSecondaryCurrency($user);
        $from = $user->setting->whereUserId($user->id)->first()?->primary_currency;
        $to = Coin::whereIsDefault(1)->first()?->coin_id;
        return $this->priceConversion($from, $to, $grouped);
    }
}
