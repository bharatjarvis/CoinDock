<?php

use App\Http\Controllers\V1\Auth\UserController;
use App\Http\Controllers\V1\WalletCoinController;
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



Route::middleware('auth:api')->prefix('users')->group(function(){

    Route::post('/', [UserController::class, 'create'])->name('users.create');
    Route::prefix('{user}')->group(
        function(){
            Route::prefix('recovery-codes')->group(
                function(){     
                    Route::post('/', [ RecoveryKeyController::class, 'create' ]);
                    
                    Route::get('/download', [ RecoveryKeyController::class, 'download' ]);

                    Route::put('/activate', [RecoveryKeyController::class, 'activate']);
            });
    });

});

Route::get('/users/{user}/signup/status/',[UserController::class,'signUpInfo'])
->missing(fn () => response([
    'error' => [
        'message' => 'User record not found']], 404));


Route::get('/users/graphical/{user}/status/',[WalletCoinController::class,'index'])
    ->missing(fn () => response([
        'error' => [
            'message' => 'User record not found']], 404)
);



