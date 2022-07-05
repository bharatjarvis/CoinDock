<?php
 
return[
 
    'coin' =>[
        'apiurl' => env('COINAPI_URL'),
        'apikey'=> env('COINAPI_KEY'),
        'exchangeURL'=>'/exchangerate/{from}/{to}/',
    ],
 
];