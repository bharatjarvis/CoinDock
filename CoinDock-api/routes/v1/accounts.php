<?php

use App\Http\Controllers\V1\UserController;
use App\Models\V1\RecoveryKey;
use Illuminate\Support\Facades\Route;


Route::group(['prefix'=>'accounts','middleware'=>'auth:api'],function(){
    Route::group(['prefix'=>'users'],function(){
        Route::group(['prefix'=>'{user}'],function(){
            Route::put('/change-password',[UserController::class,'changePassword']);
            Route::put('/profile',[UserController::class,'updateProfile']);
        });
    });
});








?>