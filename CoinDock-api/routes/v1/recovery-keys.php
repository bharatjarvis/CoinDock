<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\RecoveryKeyController;
use App\Http\Controllers\V1\WalletController;
use App\Models\V1\RecoveryKey;
use App\Models\V1\Wallet;

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
    function () {

        Route::prefix('{user}')->group(
            function () {
                Route::prefix('recovery-codes')->group(
                    function () {
                        Route::get('/', [RecoveryKeyController::class, 'show']);

                        Route::get('/download', [RecoveryKeyController::class, 'download']);
                    }
                );
            }
        );
    }
);

Route::get('/wallets', [WalletController::class ,'index']);