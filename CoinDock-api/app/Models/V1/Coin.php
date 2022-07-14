<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
