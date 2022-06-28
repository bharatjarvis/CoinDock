<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\V1\User;
use Composer\Config;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class Coin extends Model
{
    use HasFactory;
    protected $fillable = ['name'];


    public function wallet(){

        return $this->hasMany(Wallet::class);

    }

    //Number of Coins
    public function countCoins(User $user){
        $data= Wallet::select(['coin_id',
                            'balance',
                            ])
                            ->whereUserId($user->id)
                            ->get();
        $grouped = $data->mapToGroups(function($wallet){
                            return [$wallet->coin->name => $wallet->balance];})
                        ->map(function ($row) {
                            return $row->sum();
        });
        return $grouped;
    }

    //Convertion
    public function priceConversion($from, $to, User $user)
    {
        $grouped =$this->countCoins($user)->toArray(); 
        $url = Config('coinapi.coinapi.coinapiurl'); 
        $cryptConversionId1 = str_replace('{from}', $from,$url);
        $cryptConversionId1 = $cryptConversionId1;
        $cryptConversionURL = str_replace('{to}', $to, $cryptConversionId1);
        $balanceCurrency = Http::get($cryptConversionURL); 
        $priceValue = explode(":",$balanceCurrency);        
        $priceValue = str_replace("}","",$priceValue[1]);       
        $priceArray = array();
        foreach($grouped as $groupedValue){
            $priceValue = $priceValue * $groupedValue;
            $priceArray = array_merge($priceArray,[$priceValue]);
        }
        return $priceArray;
        
    }

     //PrimaryCurrency Exchange
    public function exChange(Request $request,User $user){
        $from= config('currency.currency.primarycurrency') ;
        $to = $request->to;
        $data = $this->priceConversion($from,$to ,$user);
        return $data;
    }


    //get the primary currency value
    public function getPrimaryCurrency(User $user){

        //$from= 'BTC';
        $from =config('shortnames.shorted_coin_list.Bitcoin');
        $to = config('currency.currency.primarycurrency');
        $data = $this->priceConversion($from,$to ,$user);
        return $data;

    }
    //Secondary currency exchange
    public function secondayCurrencyexChange(Request $request,User $user){
        $from= config('currency.currency.secondarycurrency');
        $to = $request->to;
        $data = $this->priceConversion($from,$to ,$user);
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
                            return [$wallet->coin_id =>$wallet->bUSD];})
                        ->map(function ($row) {
                            return $row->sum();
        });
        return $grouped;

    }

    //Coin in the form of BTC
    public function coinBtc(User $user)
    {       
        $grouped=$this->getSecondaryCurrency($user);
        $from= config('currency.currency.secondarycurrency');
        $to = config('shortnames.shorted_coin_list.Bitcoin');
       $url = Config('coinapi.coinapi.coinapiurl'); 
        $cryptConversionId1 = str_replace('{from}', $from,$url);
         $cryptConversionId1 = $cryptConversionId1;
        $cryptConversionURL = str_replace('{to}', $to, $cryptConversionId1);
        $balanceCurrency = Http::get($cryptConversionURL);
        $priceValue = explode(":",$balanceCurrency);        
        $priceValue = str_replace("}","",$priceValue[1]);       
        $priceArray = array();
        foreach($grouped as $groupedValue){
            $priceValue = $priceValue * $groupedValue;
            $priceArray = array_merge($priceArray,[$priceValue]);
        }
        return $priceArray;
    }
}
