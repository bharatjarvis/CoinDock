<?php
 
return[
 
    'coin' =>[
        'api_url' => env('COINAPI_URL','https://rest.coinapi.io/v1'),
        'api_key'=> env('COINAPI_KEY'),
        'usd_to_Btc'=>'/exchangerate/USD/BTC/',
        'primary_currency'=>'/exchangerate/USD/{id}/',
        'top_performer'=>'/exchangerate/{id}/USD/',
        'exchange_url' => '/exchangerate/{from}/{to}/',
        'realtime_url' => '/exchangerate/{coin1}/USD/history?period_id={range}&time_start={start_date}&time_end={end_date}',
        'users_realtime_url' => '/exchangerate/{coin1}/USD/history?period_id={range}&time_start={start_date}',
        'filter_url'=> '/exchangerate/history/periods'
    ],
    

    'keys'=>env('COINAPI_KEY_LIST')

];