<?php

namespace App\Models\V1;

use Illuminate\Http\Request;
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


    public function edit(User $user , Request $request){

        $userSettings = $user->settings();
        $settings = $request->all();

        $userSettings->update($settings);

        return response([
            'message'=>'Settings Updated Successfully'
        ],200);
    }
}
