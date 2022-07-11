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
    For        : Listing all the coins
    RouteName  : /coins/
    Method     : GET
    Access     : Private
    */
    Route::get('/accepted-assets', [CoinController::class , 'acceptedAssets']);


    
    /*
    For        : Show a particular Coin
    RouteName  : /coins/{coin}
    Method     : SHOW
    Access     : Private
    */
    Route::get('/{coin}',[CoinController::class , 'show']);


    
    /*
    For        : Updating Coin Details
    RouteName  : /coins/{coin}
    Method     : PUT
    Access     : Private
    */
    Route::put('/{coin}',[CoinController::class , 'update']);


    
    /*
    For        : Delete a Coin
    RouteName  : /coins/{coin}
    Method     : DELETE
    Access     : Private
    */
    Route::delete('/{coin}',[CoinController::class , 'delete']);

    




});