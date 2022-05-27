<?php

use App\Http\Controllers\V1\RecoveryKeyController;
use Illuminate\Support\Facades\Route;

//middleware('auth:api')->
Route::prefix('users')->group(

    function () {
        Route::prefix('{user}')->group(

            function () {

                Route::prefix('recovery-keys')->group(

                    function () {
                        Route::put('/activate', [RecoveryKeyController::class, 'activate']);
                    });

            });

    });


    Route::get('/random', [RecoveryKeyController::class, 'random']);
