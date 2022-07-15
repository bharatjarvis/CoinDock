<?php
 
return[
 
    'coin' =>[
        'api_url' => env('COINAPI_URL','https://rest.coinapi.io/v1'),
        'api_key'=> env('COINAPI_KEY'),
        'usd_to_Btc'=>'/exchangerate/USD/BTC/',
        'primary_currency'=>'/exchangerate/USD/{id}/',
        'top_performer'=>'/exchangerate/{id}/USD/'
    ],
 
];