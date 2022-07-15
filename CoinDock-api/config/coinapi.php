<?php

return [

    'coin' => [
        'api_url' => env('COINAPI_URL'),
        'api_key' => env('COINAPI_KEY'),
        'exchange_url' => '/exchangerate/{from}/{to}/',
    ],

];
