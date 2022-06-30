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
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/604ae4533d9f4ad09a489905cce617c2.png'
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
            'img_path' => ''
        ],
        'Ergo' => [
            'coin_id' => 'ERGO',
            'bal_path' => 'https://api.ergoplatform.com/api/v1/addresses/{id}/balance/total',
            'img_path' => ''
        ],
        'Callisto Network' => [
            'coin_id' => 'CLO',
            'bal_path' => 'https://explorer.callisto.network/api?module=account&action=balance&address={id}',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/bb5be7857eb74991adfa26a7e641301c.png'
        ],
        'BitcoinZ' => [
            'coin_id' => 'BTCZ',
            'bal_path' => 'https://explorer.btcz.rocks/api/addr/{id}/?noTxList=1',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/7ec2ce6060674da58e39eae2a178369f.png'
        ],
        'Litecoin' => [
            'coin_id' => 'BTCZ',
            'bal_path' => 'https://api.blockcypher.com/v1/ltc/main/addrs/{id}/balance',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/a201762f149941ef9b84e0742cd00e48.png'
        ],
        'TON' => [
            'coin_id' => 'TON',
            'bal_path' => 'https://toncenter.com/api/v2/getAddressBalance?address={id}',
            'img_path' => ''
        ],
        'Dash' => [
            'coin_id' => 'DASH',
            'bal_path' => 'https://api.blockcypher.com/v1/dash/main/addrs/{id}/balance',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/73fb6d7915a24f51930809b9e2b84c8f.png'
        ],
        'Aeternity' => [
            'coin_id' => 'AE',
            'bal_path' => 'https://mainnet.aeternity.io/v3/accounts/{id}',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/8ab076bf9aa44639bd2d776bacd899ee.png'
        ],
        'Expanse' => [
            'coin_id' => 'EXP',
            'bal_path' => 'https://explorer.expanse.tech/web3relay',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/a47c9f47c4c4436ba622ecc2696c51db.png'
        ],

        'Vertcoin' => [
            'coin_id' => 'VTC',
            'bal_path' => 'https://chainz.cryptoid.info/explorer/address.summary2.dws?coin=vtc&id={id}',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/0dc872e680f14d068f8e0dca025589f8.png'
        ],
        'Conflux' => [
            'coin_id' => 'CFX',
            'bal_path' => 'https://chainz.cryptoid.info/explorer/address.summary2.dws?coin=vtc&id={id}',
            'img_path' => ''
        ],
        'US Dollar' => [],
        'Indian Rupee' => [],
        'Canadian Dollar' => [],
    ],

    'coin_api' => [
        'base_path' => env('COINAPI_URL'),
        'key' => env('COINAPI_KEY'),
        'assets_path' => '/assets',
        'asset_images' => '/assets/icons/BTC',
        'crypto_usd'=>'/exchangerate/{id}/USD'

    ]

];
