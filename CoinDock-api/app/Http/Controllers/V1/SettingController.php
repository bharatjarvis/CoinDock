<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\Setting;
use App\Models\V1\User;
use Illuminate\Http\Request;
use SebastianBergmann\CodeUnit\FunctionUnit;

class SettingController extends Controller
{
    public function editCurrency(User $user , Request $request){
        $setting = new Setting();
        return $setting->edit($user,$request);
    }
}
