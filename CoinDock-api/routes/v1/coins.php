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


    /*
    For        : Create a Coin
    RouteName  : /coins/
    Method     : POST
    Access     : Private
    */
    Route::post('/',[CoinController::class , 'store']);


    
    /*
    For        : Listing all the coins
    RouteName  : /coins/
    Method     : GET
    Access     : Private
    */
    Route::get('/', [CoinController::class , 'index']);


    
    /*
    For        : Show a particular Coin
    RouteName  : /coins/{user}
    Method     : SHOW
    Access     : Private
    */
    Route::get('/{user}',[CoinController::class , 'show']);


    
    /*
    For        : Updating Coin Details
    RouteName  : /coins/{user}
    Method     : PUT
    Access     : Private
    */
    Route::put('/{user}',[CoinController::class , 'update']);


    
    /*
    For        : Delete a Coin
    RouteName  : /coins/{user}
    Method     : DELETE
    Access     : Private
    */
    Route::delete('/{user}',[CoinController::class , 'delete']);

    
});