<?php

use App\Http\Controllers\V1\Auth\UserController;
use App\Http\Controllers\V1\CoinsController;
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
Route::post('/login', [UserController::class, 'login']);
Route::post('/refresh', [UserController::class, 'refresh']);
Route::middleware('auth:api')->group(function () {

    Route::post('logout', [UserController::class, 'logout']);
    Route::get('logout', [UserController::class, 'logout']);
});

Route::middleware('auth:api')->prefix('users')->group(
    function () {

        Route::prefix('{user}')->group(
            function () {

                Route::get('/total-btc', [CoinsController::class, 'totalBTC']);
                Route::get('/primary-currency',[CoinsController::class, 'currencyConverter']);
                Route::get('/top-performer', [CoinsController::class, 'topPerformer']);
                Route::get('/low-performer', [CoinsController::class, 'lowPerformer']);
            }
        );
    }
);
