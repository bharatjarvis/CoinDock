<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricalData extends Model
{
    use HasFactory;
    protected $fillable = [
        'coin_id',
        'coin_date',
        'rate_close'
    ];
}
