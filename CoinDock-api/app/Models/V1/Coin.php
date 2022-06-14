<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\V1\User;
use Illuminate\Support\Arr;

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

    //Coin in the form of BTC
    public function coinBtc(User $user, Request $request){
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
        //dd($grouped);
        $from= 'USD';
        $to = 'BTC';
        $url = file_get_contents("https://min-api.cryptocompare.com/data/price?fsym=".$from."&tsyms=".$to."");   
        $priceValue = explode(":",$url);        
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
        $from= 'INR';
        $to = $request->to;
        $grouped =$this->countCoins($user)->toArray();
        $url = file_get_contents("https://min-api.cryptocompare.com/data/price?fsym=".$from."&tsyms=".$to."");   
        $priceValue = explode(":",$url);        
        $priceValue = str_replace("}","",$priceValue[1]);       
        $priceArray = array();
        foreach($grouped as $groupedValue){
            $priceValue = $priceValue * $groupedValue;
            $priceArray = array_merge($priceArray,[$priceValue]);
        }
        return $priceArray;
    }


    //get the primary currency value
    public function getPrimaryCurrency(User $user){

        $from= 'BTC';
        $to = 'INR';
        $grouped =$this->countCoins($user)->toArray();
        $url = file_get_contents("https://min-api.cryptocompare.com/data/price?fsym=".$from."&tsyms=".$to."");   
        $priceValue = explode(":",$url);        
        $priceValue = str_replace("}","",$priceValue[1]);       
        $priceArray = array();
        foreach($grouped as $groupedValue){
            $priceValue = $priceValue * $groupedValue;
            $priceArray = array_merge($priceArray,[$priceValue]);
        }
        return $priceArray;

    }
    //Secondary currency exchange
    public function secondayCurrencyexChange(Request $request,User $user){
        $from= 'USD';
        $to = $request->to;
        $grouped =$this->countCoins($user)->toArray();
        $url = file_get_contents("https://min-api.cryptocompare.com/data/price?fsym=".$from."&tsyms=".$to."");   
        $priceValue = explode(":",$url);        
        $priceValue = str_replace("}","",$priceValue[1]);       
        $priceArray = array();
        foreach($grouped as $groupedValue){
            $priceValue = $priceValue * $groupedValue;
            $priceArray = array_merge($priceArray,[$priceValue]);
        }
        return $priceArray;
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
}
