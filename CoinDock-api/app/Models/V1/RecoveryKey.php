<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecoveryKey extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'recovery_code',
        'status'
    ];

    public function user(){
        $this->belongsTo(User::class ,'user_id');
    }
}
