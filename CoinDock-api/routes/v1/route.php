<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\HomeController;

 
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
                Route::get('/numberOfCoins', [HomeController::class, 'numberOfCoins']);
                Route::get('/coinBtc',[HomeController::class,'coinBtc']);
                Route::get('/getprimaryCurrency', [HomeController::class, 'getPrimaryCurrency']);
                Route::post('/primaryCurrency', [HomeController::class, 'primaryCurrency']);
                Route::get('/getsecondarycurrency',[HomeController::class, 'getSecondaryCurrency']);
                Route::post('/secondaryCurrency', [HomeController::class, 'secondaryCurrency']);

                
            }
        );
    }
);




