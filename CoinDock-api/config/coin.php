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
    
    'accepted_coins'=>[

        'BTC','ETH','ETC','RVN','FIRO','FLUX','ERG',

        'CLO','BTCZ','LTC','TON','DASH','AE','EXP','VTC',

        'CFX','EGEM','GRLC','AION','UBQ'

    ],



    'keys'=>[

        'C895A902-2F8D-460C-9A87-8A40DE01AD67','8997362A-4220-443E-BA02-CB15D01CEFDE',

        'AF167628-02EA-41D1-BEE3-55FD96E7115C','F21719F9-5858-43F0-8C9E-593478CDAFE3',

        '6A936DA6-7D2E-4FB7-ABDA-C9F883BC64A0','612FD155-5A24-49B1-BE47-D0449E8E2545',

        '25C601CD-A2E9-4B67-B034-65F81CEB272E','8F29C8FD-FEE7-43A2-B421-D8CF3A52ADCC',

        '5733731E-1E6A-4713-9881-48B4B7F4A5CE','612FD155-5A24-49B1-BE47-D0449E8E2545',

        'CFD3BBB1-B1DF-4C9D-A826-3753361FD440','01FAE827-EAAC-4845-BAFB-07F9926C0B34',

        'AB3385B2-305D-4780-BFAC-ABA36EDF26B8','71F01597-DEBF-4A4B-904D-F33F1F57FBC4',

        'E95EB4DB-65C4-48B3-8775-5AE85A104086','FF50C17E-FA72-48C6-A3ED-0450E276B54A',

        '0D42E190-CDFB-45CD-9174-598F800631C1','4A46869D-6CBC-42AD-9164-9CDF375D5114',

        'B5BF4B67-D24F-49AC-9D61-DC6089DAF521','4F11BD50-8EEE-4B1F-9E8A-DB1E68967DF6',

        '2D2C76B1-C770-4816-AF75-5E72698F9A00','56EE8D51-50C2-4991-ADFB-400183A23F0B',

    ]
];