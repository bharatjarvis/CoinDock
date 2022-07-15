<?php

use App\Models\V1\User;
use App\Http\Controllers\V1\{
    CoinController,
    GraphController,
    PieChartController,
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

Route::group(['prefix' => 'users'], function () {
    Route::post('/', [UserController::class, 'create'])->name('users.create');
});
// route should be placed in CoinController
Route::get('/coins/coinshortname',[CoinController::class, 'index']);

Route::middleware('auth:api')

    ->prefix('users')

    ->group(function () {

        Route::prefix('{user}')->group(function () {

            Route::prefix('recovery-codes')->group(function () {

                Route::post('/', [RecoveryKeyController::class, 'create']);

                Route::get('/download', [RecoveryKeyController::class, 'download']);

                Route::get('/random', [RecoveryKeyController::class, 'random']);

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

            Route::prefix('pie-chart')->group(function () {

                Route::get('/', [PieChartController::class, 'show'])->missing(
                    fn () => response(
                        [
                            'error' => ['message' => 'User record not found'],
                        ],
                        404,
                    ),
                );

                Route::get('/filter', [PieChartController::class, 'filter']);
                
            });

            Route::prefix('graph')->group(function () {

                Route::prefix('coins')->group(function () {
                    Route::get('/', [GraphController::class,'getCoinIds']);
                });

                Route::get('/filter', [GraphController::class, 'filter']);

                Route::get('/', [GraphController::class, 'show']);
            });
        });
    });
