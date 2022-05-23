<?php

namespace App\Models\V1;

use App\Enums\V1\RecoveryKeyStatus;
use App\Models\V1\Traits\Encryptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecoveryKey extends Model
{
    use HasFactory, Encryptable;

    protected $fillable = [
        'user_id',
        'recovery_code',
        'status'
    ];

    protected $encryptable = ['recovery_code'];

    protected $casts = [
        'status' => RecoveryKeyStatus::class,
    ];


    public function user()
    {
        $this->belongsTo(User::class, 'user_id');
    }
}
