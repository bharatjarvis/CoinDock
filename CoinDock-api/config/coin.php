<?php
 
return[
 
    'coinapi' =>[
        'coinapiurl' => env('COINAPI_URL'),
        'coinapikey'=> env('COINAPI_KEY'),
        'usdToBtc'=>'/exchangerate/USD/BTC/',
        'primaryCurrency'=>'/exchangerate/USD/{id}/',
        'topPerformer'=>'/exchangerate/{id}/USD/'
    ],
 
];