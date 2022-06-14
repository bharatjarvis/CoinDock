<?php

use App\Http\Controllers\V1\CoinController;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'coins', 'middleware' => 'auth:api'], function () {

    Route::post('/',[CoinController::class , 'store']);
    Route::get('/', [CoinController::class , 'index']);
    Route::get('/{user}',[CoinController::class , 'show']);
    Route::put('/{user}',[CoinController::class , 'update']);
    Route::delete('/{user}',[CoinController::class , 'delete']);

});