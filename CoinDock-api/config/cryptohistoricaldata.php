<?php


// return[

//     'coin_api_key'=>env("COIN_API_KEY"),
//     'minute'=> "https://min-api.cryptocompare.com/data/v2/histominute?fsym={id}&tsym=USD&limit=100",
//     'hourly'=> "https://min-api.cryptocompare.com/data/v2/histohour?fsym={id}&tsym=USD&limit=100",
//     'daily'=> "https://min-api.cryptocompare.com/data/v2/histoday?fsym={id}&tsym=USD&limit=100",
//     //'convertor'=> "https://min-api.cryptocompare.com/data/price?fsym={id1}&tsyms={id2}",
//     'piechartconvertor'=>'https://rest.coinapi.io/v1/exchangerate/{id1}/{id2}',
// ]


return[
 
    'coin_api' =>[
        
        'coin_api_url' => env('COIN_API_URL'),
        'coin_api_key'=> env('COIN_API_KEY'),
    ],
 
];

?>