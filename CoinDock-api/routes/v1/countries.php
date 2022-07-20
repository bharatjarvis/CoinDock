<?php


use App\Http\Controllers\V1\CountryController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'countries'] , function(){
    Route::get('/',[CountryController::class,'index']);
});

