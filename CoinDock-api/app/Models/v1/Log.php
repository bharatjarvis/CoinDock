<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $fillable = ['log_type','user_id'];

    public function user(){

        return $this->belongsTo(User::class);
        
    }

    public function wallet(){

        return $this->belongsTo(Wallet::class);
        
    }
}
