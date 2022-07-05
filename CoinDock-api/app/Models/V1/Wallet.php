<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\V1\CoinsController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use phpDocumentor\Reflection\Types\Null_;

class Wallet extends Model
{
    use HasFactory;

   
    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }
}
