<?php
 
return[
 
    'coin' =>[
        'apiurl' => env('COINAPI_URL','https://rest.coinapi.io/v1'),
        'apikey'=> env('COINAPI_KEY'),
        'usdToBtc'=>'/exchangerate/USD/BTC/',
        'primaryCurrency'=>'/exchangerate/USD/{id}/',
        'topPerformer'=>'/exchangerate/{id}/USD/'
    ],
 
];