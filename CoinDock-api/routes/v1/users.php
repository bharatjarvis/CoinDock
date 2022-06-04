<?php

use App\Http\Controllers\V1\Auth\UserController;
use App\Http\Controllers\V1\RecoveryKeyController;
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
Route::post('/signup', [UserController::class, 'store'])->name('users.signup');


Route::middleware('auth:api')->prefix('user')->group(function(){


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


