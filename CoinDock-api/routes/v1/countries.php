<?php


use App\Http\Controllers\V1\CountryController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'countries','middleware'=>'auth:api'] , function(){
    Route::get('/',[CountryController::class,'index']);
});