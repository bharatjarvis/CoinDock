<?php

namespace App\Models\V1;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\V1\{ User, Coin, Setting};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'coin_id',
        'user_id',
        'wallet_id',
        'balance'
    ];

    // relationship
    public function coin(){
        return $this->belongsTo(Coin::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }


}

