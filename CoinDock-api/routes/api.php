<?php

use App\Models\v1\RecoveryKey;
use App\Models\V1\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Boolean;
use App\Http\Controllers\V1\RecoveryKeyController;

 
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
    
// });
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
   // return $request->user();
//});

Route::get('/random/recovery_number',[RecoveryKeyController::class,'random_numbers']);
Route::post('/confirm/{user}/recoverycodes', [RecoveryKeyController::class,'recovery_keys']);


//Route::get('/random' , function(){


   // $random = Arr::random(config('random_keys.recovery_codes'),12);
    
//});
