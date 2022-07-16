<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\editSettingsRequest;
use App\Models\V1\Setting;
use Symfony\Component\HttpFoundation\Response;

class SettingController extends Controller
{
    public function editCurrency(editSettingsRequest $request)
    {
        $setting = new Setting();
        if ($setting->edit($request)) {

            return response([
                'message' => 'Settings Updated Successfully'
            ], Response::HTTP_OK);

        }
        return response([
            'message'=>'settings can not be updated',
        ],Response::HTTP_BAD_REQUEST);
    }
}