<?php

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

Route::middleware('auth:api')->prefix('users')->group(
    function(){

        Route::prefix('{user}')->group(
            function(){
                Route::prefix('recovery-codes')->group(
                    function(){     
                        Route::get('/', [ RecoveryKeyController::class, 'show' ]);
                        
                        Route::get('/download', [ RecoveryKeyController::class, 'download' ]);

                        Route::put('/activate', [RecoveryKeyController::class, 'activate']);
                });
        });
    
});

Route::get('/random', [RecoveryKeyController::class, 'random']);
