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
Route::post('/login', [UserController::class, 'login']);
Route::post('/refresh', [UserController::class, 'refresh']);
Route::middleware('auth:api')->group(function(){
   Route::get('logout', [UserController::class, 'logout']);
});


