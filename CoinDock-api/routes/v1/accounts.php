<?php

use App\Http\Controllers\V1\RecoveryKeyController;
use App\Http\Controllers\V1\SettingController;
use App\Http\Controllers\V1\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix'=>'accounts','middleware'=>'auth:api'],function(){
    Route::group(['prefix'=>'users'],function(){
        Route::group(['prefix'=>'{user}'],function(){

            /*
                    For        : Change password
                    RouteName  : accounts/users/{user}/change-password
                    Method     : PUT
                    Access     : Private
            */
            Route::put('/change-password',[UserController::class,'changePassword']);


            /*
                    For        : Recovery Codes generation
                    RouteName  : accounts/users/{user}/profile/
                    Method     : PUT
                    Access     : Private
            */
            Route::put('/profile',[UserController::class,'updateProfile']);


            /*
                    For        : Recovery Codes Re-generation
                    RouteName  : accounts/users/{user}/recovery-codes/
                    Method     : PUT
                    Access     : Private
            */
            Route::put('/recovery-codes',[RecoveryKeyController::class,'reGenerateRecoveryKeys']);



            /*
                    For        : Recovery Codes generation
                    RouteName  : accounts/users/{user}/settings/
                    Method     : PUT
                    Access     : Private
            */
            Route::put('/settings',[SettingController::class,'editCurrency']);
        });
    });
});








?>