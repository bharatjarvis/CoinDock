<?php

namespace App\Models\V1;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'primary_currency',
        'secondary_currency'
        
    ];


    public function edit(Request $request,User $user){

        $request = $request->all();
        $userSettings = $user->setting;
        
        $userSettings->update($request);
        return true;
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

}
