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

    
}
