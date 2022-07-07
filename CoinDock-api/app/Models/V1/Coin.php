<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\V1\User;
use Illuminate\Support\Facades\Http;

class Coin extends Model
{
    use HasFactory;
    protected $fillable = ['coin_id','name', 'is_crypto', 'status', 'img_path', 'is_default'];


    public function wallet(){

        return $this->hasMany(Wallet::class);

    }

    public function logo(User $user){

        $coindata= Wallet::select('coin_id')->whereUserId($user->id)->get();
        $coinImages = [];
        $logodata = [];
        foreach($coindata as $coinId){
            $coinImageLink = Coin::select('coin_id','img_path')->find($coinId['coin_id']);
            array_push($coinImages,$coinImageLink);
        }    
        foreach($coinImages as $coinImage){
            $logodata[$coinImage['coin_id']] = $coinImage['img_path'];
        }
        return ($logodata);

    }
    //Number of Coins
    public function countCoins(User $user){
        $data= Wallet::select(['coin_id',
                            'balance',
                            ])
                            ->whereUserId($user->id)
                            ->get();
        $grouped = $data->mapToGroups(function($wallet){
                            return [$wallet->coin->coin_id => $wallet->balance];})
                        ->map(function ($row) {
                            return $row->sum();
        });
        return $grouped;
    }

    //Convertion
    public function priceConversion($from, $to, $grouped)
    {
        
        $baseUrl = config('coinapi.coin.apiurl');
        $currencyURL = $baseUrl . config('coinapi.coin.exchangeURL');
        $cryptConversionId1 = str_replace('{from}', $from,$currencyURL);
        $cryptConversionId1 = $cryptConversionId1;
        $cryptConversionURL = str_replace('{to}', $to, $cryptConversionId1);
        $url = Http::withHeaders(['X-CoinAPI-Key' => config('coinapi.coin.apikey')])->get($cryptConversionURL);
        $price = $url['rate'];  
        $priceArray = array();
        foreach($grouped as $key=>$value){
            $priceValue = $price * $value;
            $priceArray = array_merge($priceArray,[$key => $priceValue]);
        }
        return $priceArray;
        
    }


    //get the primary currency value
    public function getPrimaryCurrency(User $user){

        //$from= 'BTC';
        $grouped =$this->countCoins($user);
        $coins= Coin::all();
        foreach ($coins as $coin){
            if($coin->is_default==1){
                $from = $coin->coin_id;
            }
        }
        $tabledata = Setting::whereUserId($user->id)->first();
        $to = $tabledata->primary_currency;
        $data = $this->priceConversion($from,$to ,$grouped);
        return $data;

    }


    //get secondary currency value
    public function getSecondaryCurrency(User $user){
        $content=Wallet::select(['coin_id',
                                  'bUSD',
                                ])
                                ->whereUserId($user->id)
                                ->get();
        $grouped = $content->mapToGroups(function($wallet){
                            return [$wallet->coin->coin_id =>$wallet->bUSD];})
                        ->map(function ($row) {
                            return $row->sum();
        });
        return $grouped;

    }

    //Coin Default Value
    public function coinDefault(User $user)
    {
        $grouped = $this->getSecondaryCurrency($user);
        $tabledata = Setting::whereUserId($user->id)->first();
        $from = $tabledata->primary_currency;
        $coins = Coin::all();
        foreach ($coins as $coin) {
            if ($coin->is_default == 1) {
                $to = $coin->coin_id;
            }
        }
        $data = $this->priceConversion($from,$to ,$grouped);
        return $data;   
    }







   




}
