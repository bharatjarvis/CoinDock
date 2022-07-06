<?php

return[
 
    'coin' =>[
        'api_url' => env('COIN_API_URL','https://rest.coinapi.io/v1'),
        'api_key'=> env('COIN_API_KEY'),
        'exchange_url' => '/exchangerate/{id1}/{id2}',
        'realtime_url' => '/exchangerate/{coin1}/USD/history?period_id={range}&time_start={start_date}&time_end={end_date}',
        'users_realtime_url' => '/exchangerate/{coin1}/USD/history?period_id={range}&time_start={start_date}',
        'filter_url'=> '/exchangerate/history/periods'

    ],
 
];

?>