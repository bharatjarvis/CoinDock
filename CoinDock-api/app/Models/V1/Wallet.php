<?php

namespace App\Models\V1;

use Composer\DependencyResolver\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'coin_id',
        'user_id',
        'wallet_id',
        'USD_balance',
        'coins',
        'name'
    ];


    public function coin(){
        return $this->belongsTo(Coin::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }



}

