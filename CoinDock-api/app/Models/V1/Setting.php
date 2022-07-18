<?php

namespace App\Models\V1;

use App\Http\Requests\V1\editSettingsRequest;
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


    public function edit(editSettingsRequest $request)
    {
        return $this->update($request->all());
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
