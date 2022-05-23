<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
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
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout']);
Route::middleware('auth:api')->group(function(){
    Route::get('logout', [UserController::class, 'logout']);
});
Route::get('/recoverykey',function(){
    $array = [1, 2, 3, 4, 5,6,7,8,9,10,11,12];
 
     $random = Arr::random($array,3);
     return $random;
});

Route::get('/random' , function(){


    $random = Arr::random(config('random_keys.recovery_codes'),12);
    
});
