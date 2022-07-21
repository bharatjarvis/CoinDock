<?php

return[

    'coin' =>[
        'api_url' => env('COINAPI_URL','https://rest.coinapi.io/v1'),
        'api_key'=> env('COINAPI_KEY'),
        'usd_to_btc'=>'/exchangerate/USD/BTC/',
        'primary_currency'=>'/exchangerate/USD/{id}/',
        'exchange_url' => '/exchangerate/{from}/{to}/',
        'realtime_url' => '/exchangerate/{coin1}/USD/history?period_id={range}&time_start={start_date}&time_end={end_date}',
        'users_realtime_url' => '/exchangerate/{coin1}/USD/history?period_id={range}&time_start={start_date}',
        'filter_url'=> '/exchangerate/history/periods',
        'assets_path' => '/assets',
        'asset_images' => '/assets/icons/BTC',
        'crypto_to_usd' => '/exchangerate/{id}/USD'
    ],

];