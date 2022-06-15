<?php

namespace App\Models\V1;

use App\Http\Controllers\V1\CoinsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
  public function wallet()
  {
    return $this->hasMany(Wallet::class);
  }
}
