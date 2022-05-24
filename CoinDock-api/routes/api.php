<?php

use App\Http\Controllers\V1\RecoveryKeyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Arr;
 
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/recoverykey',function(){
    $array = [1, 2, 3, 4, 5,6,7,8,9,10,11,12];
 
     $random = Arr::random($array,3);
     return $random;
});


Route::post('{user}/recovery_codes/',[RecoveryKeyController::class,'generateRecoveryCodes']);

Route::get('{user}/download-recovery_codes',[RecoveryKeyController::class ,'downloadRecoveryWords']);