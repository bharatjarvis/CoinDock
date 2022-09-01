<?php

return [
    'accepted_coins' => [
        'BTC' => [
            'coin_name' => 'Bitcoin',
            'bal_path' => 'https://api.blockcypher.com/v1/btc/main/addrs/{id}/balance',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/4e4b22c74d06452288f1edd50540af3a.png'
        ],
        'ETH' => [
            'coin_name' => 'Ethereum',
            'bal_path' => 'https://api.blockcypher.com/v1/eth/main/addrs/{id}/balance',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/604ae4533d9f4ad09a489905cce617c2.png'
        ],
        'ETC' => [
            'coin_name' => 'Ethereum Classic',
            'bal_path' => 'https://blockscout.com/etc/mainnet/api?module=account&action=balance&address={id}',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/604ae4533d9f4ad09a489905cce617c2.png',
            'sats_to_crypt'=>0.000000000000000000999978871994
        ],
        'RVN' => [
            'coin_name' => 'Ravencoin',
            'bal_path' => 'https://api.ravencoin.org/api/addr/{id}/?noTxList=1',
            'img_path' => ''
        ],
        'FIRO' => [
            'coin_id' => 'FIRO',
            'coin_name' => 'Ravencoin',
            'bal_path' => 'https://explorer.firo.org/insight-api-zcoin/addr/{id}/?noTxList=1',
            'img_path' => ''
        ],

        'FLUX' => [
            'coin_id' => 'FLUX',
            'coin_name' => 'Ravencoin',
            'bal_path' => 'https://api.runonflux.io/explorer/balance?address={id}',
            'img_path' => '',
            'sats_to_crypt'=>0.00000001

        ],
        'ERG' => [
            'coin_name' => 'Ergo',
            'bal_path' => 'https://api.ergoplatform.com/api/v1/addresses/{id}/balance/total',
            'img_path' => '',
            'sats_to_crypt'=>0.000000000999996471231868024494
        ],
        'CLO' => [
            'coin_name' => 'Callisto Network',
            'bal_path' => 'https://explorer.callisto.network/api?module=account&action=balance&address={id}',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/bb5be7857eb74991adfa26a7e641301c.png',
            'sats_to_crypt'=>0.000000000000000001

        ],
        'BTCZ' => [
            'coin_name' => 'BitcoinZ',
            'bal_path' => 'https://explorer.btcz.rocks/api/addr/{id}/?noTxList=1',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/7ec2ce6060674da58e39eae2a178369f.png'
        ],
        'LTC' => [
            'coin_name' => 'Litecoin',
            'bal_path' => 'https://api.blockcypher.com/v1/ltc/main/addrs/{id}/balance',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/a201762f149941ef9b84e0742cd00e48.png'
        ],
        'TON' => [
            'coin_name' => 'TON',
            'bal_path' => 'https://toncenter.com/api/v2/getAddressBalance?address={id}',
            'img_path' => '',
            'sats_to_crypt'=>0.000000000999658829081551391916

        ],
        'DASH' => [
            'coin_name' => 'Dash',
            'bal_path' => 'https://api.blockcypher.com/v1/dash/main/addrs/{id}/balance',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/73fb6d7915a24f51930809b9e2b84c8f.png',
            'sats_to_crypt'=>0.000000000999658829081551391916
        ],
        'AE' => [
            'coin_name' => 'Aeternity',
            'bal_path' => 'https://mainnet.aeternity.io/v3/accounts/{id}',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/8ab076bf9aa44639bd2d776bacd899ee.png',
            'sats_to_crypt'=>0.00000000000000000099999951939

        ],
        'EXP' => [
            'coin_name' => 'Expanse',
            'bal_path' => 'https://explorer.expanse.tech/web3relay',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/a47c9f47c4c4436ba622ecc2696c51db.png'
        ],
        'VTC' => [
            'coin_name' => 'Vertcoin',
            'bal_path' => 'https://chainz.cryptoid.info/explorer/address.summary2.dws?coin=vtc&id={id}',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/0dc872e680f14d068f8e0dca025589f8.png',
            'sats_to_crypt'=>0.00000001
        ],
        'CFX' => [
            'coin_name' => 'Conflux',
            'bal_path' => 'https://www.confluxscan.io/v1/account/{id}',
            'img_path' => '',
            'sats_to_crypt'=>0.000000000000000000999999998343
        ],
        'EGEM' => [
            'coin_name' => 'EtherGem',
            'bal_path' => 'https://api.egem.io/account?addr={id}',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/74c6c025c0074a13904c131e65966839.png'
        ],
        'GRLC' => [
            'coin_name' => 'Garlicoin',
            'bal_path' => 'https://garli.co.in/insight-grlc-api/addr/{id}/?noTxList=1',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/5dd946607a454b9cb6fd47f97e63de40.png'
        ],
        'AION' => [
            'coin_name' => 'Aion',
            'bal_path' => 'https://mainnet-api.theoan.com/aion/dashboard/getAccountDetails?accountAddress={id}',
            'img_path' => ''
        ],
        'UBQ' => [
            'coin_name' => 'Ubiq',
            'bal_path' => 'https://mainnet-api.theoan.com/aion/dashboard/getAccountDetails?accountAddress={id}',
            'img_path' => ''
        ],
        'PLSR' => [
            'coin_name' => 'PLSR',
            'bal_path' => 'https://explorer.pulsarcoin.org/ext/getaddresstxs/{id}/0/50/internal',
            'img_path' => ''
        ],
        'NEOX' => [
            'coin_name' => 'NEOX',
            'bal_path' => 'https://explorer.neoxa.net/ext/getaddresstxs/{id}/0/50/internal',
            'img_path' => ''
        ],
        'MOAC' => [
            'coin_name' => 'MOAC',
            'bal_path' => 'https://explorer.moac.io/web3relay',
            'img_path' => ''
        ],
        'USD' => [
            'coin_name' => 'US Dollar',
            'bal_path' => '',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/0a4185f21a034a7cb866ba7076d8c73b.png'
        ],
        'INR' => [
            'coin_name' => 'Indian Rupee',
            'bal_path' => '',
            'img_path' => 'https://cdn.vectorstock.com/i/1000x1000/60/77/indian-rupee-currency-symbol-inr-money-icon-vector-34466077.webp'
        ],
        'CAD' => [
            'coin_name' => 'Canadian Dollar',
            'bal_path' => '',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/2ba6caaf33b9496e8a39dd96a1b1bbe1.png'
        ],
        'UK' => [
            'coin_name' => 'UK',
            'bal_path' => '',
            'img_path' => 'https://cdn4.iconfinder.com/data/icons/currency-symbols-4/128/12-512.png'
        ],
        'JPY' => [
            'coin_name' => 'Yen',
            'bal_path' => '',
            'img_path' => 'https://s3.eu-central-1.amazonaws.com/bbxt-static-icons/type-id/png_512/0d8862c9f9b34380b3715ced8a869e01.png'
        ]
    ],

    'default_coin' => env('DEFAULT_COIN', 'BTC')

];