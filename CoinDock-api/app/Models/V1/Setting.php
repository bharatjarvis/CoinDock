<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'primary_currency',
        'secondary_currency'
        
    ];

    public function user(){

        return $this->belongsTo(User::class);
    }

}
