<?php

use App\Http\Controllers\V1\WalletController;
use Illuminate\Support\Facades\Route;
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

Route::group(['middleware'=>'auth:api' , 'prefix' =>'users'],
    function(){

        Route::prefix('{user}')->group(
            function(){
                Route::prefix('add-wallet')->group(
                    function(){     
                        Route::post('/' ,[WalletController::class,'store']);
                });
        });
    
});