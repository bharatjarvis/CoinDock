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

Route::prefix('users')->group(
    function(){
        Route::prefix('{user}')->group(
            function(){
                Route::get('/numberOfCoins', [CoincardController::class, 'numberOfCoins']);
                Route::get('/coinBtc',[CoincardController::class,'coinBtc']);
                Route::get('/getprimaryCurrency', [CoincardController::class, 'getPrimaryCurrency']);
                Route::post('/primaryCurrency', [CoincardController::class, 'primaryCurrency']);
                Route::get('/getsecondarycurrency',[CoincardController::class, 'getSecondaryCurrency']);
                Route::post('/secondaryCurrency', [CoincardController::class, 'secondaryCurrency']);

                
            }
        );
    }
);




