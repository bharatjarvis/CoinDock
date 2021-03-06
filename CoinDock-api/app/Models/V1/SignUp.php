<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signup extends Model
{
    use HasFactory;

    protected $fillable = ['step_count','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }


}