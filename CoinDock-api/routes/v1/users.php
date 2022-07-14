<?php

use App\Http\Controllers\V1\{
    UserController,
    WalletCoinController,
    RecoveryKeyController,
    SignupController,
    CoinCardController,
    WalletController,
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

Route::group(['prefix' => 'users'], function () {
    Route::post('/', [UserController::class, 'create'])->name('users.create');
});

Route::middleware('auth:api')
    ->prefix('users')
    ->group(function () {

        Route::prefix('{user}')->group(function () {
            Route::prefix('coin-cards')->group(function(){
                Route::get('/', [CoinCardController::class, 'index']);
            });
            Route::prefix('recovery-codes')->group(function () {



                /*
                    For        : Recovery Codes generation
                    RouteName  : /users/{user}/recovery-codes/
                    Method     : POST
                    Access     : Private
                */
                Route::post('/', [RecoveryKeyController::class, 'create']);



                /*
                    For        : Downloading Recovery Words
                    RouteName  : /users/{user}/recovery-codes/download
                    Method     : GET
                    Access     : Private
                */
                Route::get('/download', [RecoveryKeyController::class, 'download']);



                /*
                    For        : Random number generation
                    RouteName  : /users/{user}/recovery-codes/random/
                    Method     : GET
                    Access     : Private
                */
                Route::get('/random', [RecoveryKeyController::class, 'random']);



                /*
                    For        : Activating Recovery Codes
                    RouteName  : /users/{user}/recovery-codes/activate/
                    Method     : POST
                    Access     : Private
                */
                Route::put('/activate', [RecoveryKeyController::class, 'activate']);

            });


            Route::prefix('signup')->group(function () {
                Route::get('/info', [SignupController::class, 'info'])->missing(
                    fn () => response(
                        [
                            'error' => ['message' => 'User record not found'],
                        ],
                        404,
                    ),
                );
            });

            Route::prefix('graph')->group(function () {
                Route::get('/', [WalletCoinController::class, 'index'])->missing(
                    fn () => response(
                        [
                            'error' => ['message' => 'User record not found'],
                        ],
                        404,
                    ),
                );
            });


            Route::prefix('add-wallet')->group(
                function () {

                    /*
                    For        : Adding an User Wallet
                    RouteName  : /users/{user}/add-wallet/
                    Method     : POST
                    Access     : Private
                */
                    Route::post('/', [WalletController::class, 'create']);
                }
            );
        });
    });
