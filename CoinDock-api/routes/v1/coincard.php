<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\CoincardController;

 
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
/* ----Dashboard ---*/

Route::middleware('auth:api')->prefix('users')->group(
    function(){
        Route::prefix('{user}')->group(
            function(){
                Route::get('/coinCard', [CoincardController::class, 'coinCard']);
            }
        );
    }
);




