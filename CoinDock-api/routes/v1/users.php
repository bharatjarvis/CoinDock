<?php

use App\Http\Controllers\V1\{
    UserController,
    WalletCoinController,
    RecoveryKeyController,
    SignupController,
};
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

Route::group(['prefix'=>'users'],function(){
    Route::post('/', [UserController::class, 'create'])->name('users.create');
});


Route::middleware('auth:api')
    ->prefix('users')
    ->group(function () {
        Route::prefix('{user}')->group(function () {
            Route::prefix('recovery-codes')->group(function () {
                Route::post('/', [RecoveryKeyController::class, 'create']);

                Route::get('/download', [RecoveryKeyController::class, 'download']);

                Route::put('/activate', [RecoveryKeyController::class, 'activate']);
            });

            Route::prefix('signup')->group(function () {
                Route::get('/info', [SignupController::class, 'info'])->missing(
                    fn() => response(
                        [
                            'error' => ['message' => 'User record not found'],
                        ],
                        404,
                    ),
                );
            });

            Route::prefix('graph')->group(function () {
                Route::get('/', [WalletCoinController::class, 'index'])->missing(
                    fn() => response(
                        [
                            'error' => ['message' => 'User record not found'],
                        ],
                        404,
                    ),
                );
            });
        });
    });