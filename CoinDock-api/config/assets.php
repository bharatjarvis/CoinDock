<?php

return [
    'accepted_coins' => [
        'Bitcoin' => [
            'coin_id' => 'BTC',
            'bal_path' => 'https://api.blockcypher.com/v1/btc/main/addrs/{id}/balance',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/4e4b22c74d06452288f1edd50540af3a.png'
        ],
        'Ethereum' => [
            'coin_id' => 'ETH',
            'bal_path' => 'https://api.blockcypher.com/v1/eth/main/addrs/{id}/balance',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/604ae4533d9f4ad09a489905cce617c2.png'
        ],
        'Ethereum Classic' => [
            'coin_id' => 'ETC',
            'bal_path' => 'https://blockscout.com/etc/mainnet/api?module=account&action=balance&address={id}',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/604ae4533d9f4ad09a489905cce617c2.png',
            'sats_to_crypt'=>0.000000000000000000999978871994
        ],
        'Ravencoin' => [
            'coin_id' => 'RVN',
            'bal_path' => 'https://api.ravencoin.org/api/addr/{id}/?noTxList=1',
            'img_path' => ''
        ],
        'FIRO' => [
            'coin_id' => 'FIRO',
            'bal_path' => 'https://explorer.firo.org/insight-api-zcoin/addr/{id}/?noTxList=1',
            'img_path' => ''
        ],

        'FLUX' => [
            'coin_id' => 'FLUX',
            'bal_path' => 'https://api.runonflux.io/explorer/balance?address={id}',
            'img_path' => '',
            'sats_to_crypt'=>0.00000001

        ],
        'Ergo' => [
            'coin_id' => 'ERG',
            'bal_path' => 'https://api.ergoplatform.com/api/v1/addresses/{id}/balance/total',
            'img_path' => '',
            'sats_to_crypt'=>0.000000000999996471231868024494
        ],
        'Callisto Network' => [
            'coin_id' => 'CLO',
            'bal_path' => 'https://explorer.callisto.network/api?module=account&action=balance&address={id}',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/bb5be7857eb74991adfa26a7e641301c.png',
            'sats_to_crypt'=>0.000000000000000001

        ],
        'BitcoinZ' => [
            'coin_id' => 'BTCZ',
            'bal_path' => 'https://explorer.btcz.rocks/api/addr/{id}/?noTxList=1',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/7ec2ce6060674da58e39eae2a178369f.png'
        ],
        'Litecoin' => [
            'coin_id' => 'LTC',
            'bal_path' => 'https://api.blockcypher.com/v1/ltc/main/addrs/{id}/balance',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/a201762f149941ef9b84e0742cd00e48.png'
        ],
        'TON' => [
            'coin_id' => 'TON',
            'bal_path' => 'https://toncenter.com/api/v2/getAddressBalance?address={id}',
            'img_path' => '',
            'sats_to_crypt'=>0.000000000999658829081551391916

        ],
        'Dash' => [
            'coin_id' => 'DASH',
            'bal_path' => 'https://api.blockcypher.com/v1/dash/main/addrs/{id}/balance',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/73fb6d7915a24f51930809b9e2b84c8f.png',
            'sats_to_crypt'=>0.000000000999658829081551391916
        ],
        'Aeternity' => [
            'coin_id' => 'AE',
            'bal_path' => 'https://mainnet.aeternity.io/v3/accounts/{id}',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/8ab076bf9aa44639bd2d776bacd899ee.png',
            'sats_to_crypt'=>0.00000000000000000099999951939

        ],
        'Expanse' => [
            'coin_id' => 'EXP',
            'bal_path' => 'https://explorer.expanse.tech/web3relay',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/a47c9f47c4c4436ba622ecc2696c51db.png'
        ],

        'Vertcoin' => [
            'coin_id' => 'VTC',
            'bal_path' => 'https://chainz.cryptoid.info/explorer/address.summary2.dws?coin=vtc&id={id}',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/0dc872e680f14d068f8e0dca025589f8.png',
            'sats_to_crypt'=>0.00000001
        ],
        'Conflux' => [
            'coin_id' => 'CFX',
            'bal_path' => 'https://www.confluxscan.io/v1/account/{id}',
            'img_path' => '',
            'sats_to_crypt'=>0.000000000000000000999999998343
        ],
        'EtherGem'=>[
            'coin_id' => 'EGEM',
            'bal_path' => 'https://api.egem.io/account?addr={id}',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/74c6c025c0074a13904c131e65966839.png'
        ],
        'Garlicoin'=>[
            'coin_id' => 'GRLC',
            'bal_path' => 'https://garli.co.in/insight-grlc-api/addr/{id}/?noTxList=1',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/5dd946607a454b9cb6fd47f97e63de40.png'
        ],
        'Aion'=>[
            'coin_id' => 'AION',
            'bal_path' => 'https://mainnet-api.theoan.com/aion/dashboard/getAccountDetails?accountAddress={id}',
            'img_path' => ''
        ],
        'Ubiq'=>[
            'coin_id' => 'UBQ',
            'bal_path' => 'https://mainnet-api.theoan.com/aion/dashboard/getAccountDetails?accountAddress={id}',
            'img_path' => ''
        ],
        'PLSR'=>[
            'coin_id' => 'PLSR',
            'bal_path' => 'https://mainnet-api.theoan.com/aion/dashboard/getAccountDetails?accountAddress={id}',
            'img_path' => ''
        ],
        'US Dollar' => [
            'coin_id' => 'USD',
            'bal_path' => '',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/0a4185f21a034a7cb866ba7076d8c73b.png'
        ],
        'Indian Rupee' => [
            'coin_id' => 'INR',
            'bal_path' => '',
            'img_path' => 'https://cdn.vectorstock.com/i/1000x1000/60/77/indian-rupee-currency-symbol-inr-money-icon-vector-34466077.webp'
        ],
        'Canadian Dollar' => [
            'coin_id' => 'CAD',
            'bal_path' => '',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/2ba6caaf33b9496e8a39dd96a1b1bbe1.png'
        ],
        'UK'=>[
            'coin_id' => 'UK',
            'bal_path' => '',
            'img_path' => 'https://cdn4.iconfinder.com/data/icons/currency-symbols-4/128/12-512.png'
        ],
        'Yen'=>[
            'coin_id' => 'JPY',
            'bal_path' => '',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/0d8862c9f9b34380b3715ced8a869e01.png'
        ]
    ],

    'coin_api' => [
        'base_path' => env('COINAPI_URL'),
        'key' => env('COINAPI_KEY'),
        'assets_path' => '/assets',
        'asset_images' => '/assets/icons/BTC',
        'crypto_usd'=>'/exchangerate/{id}/USD'  

    ]

];
