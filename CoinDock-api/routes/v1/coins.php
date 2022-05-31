<?php

use App\Models\V1\Coin;
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
Route::get('/coins', function () {
    $coins = Coin::all();
    return [
        'message' => 'coins fetched succesfully',
        'result' => [
            'coins' => $coins
        ],200
    ];
});
