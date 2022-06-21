<?php

return [
    'base_url_lst' => [
        'Bitcoin' => 'https://api.blockcypher.com/v1/btc/main/addrs/{id}/balance',
        'Ethereum' => 'https://api.blockcypher.com/v1/eth/main/addrs/{id}/balance',
        'Ethereum Classic' => 'https://blockscout.com/etc/mainnet/api?module=account&action=balance&address={id}',
        'Ravencoin' => 'https://api.ravencoin.org/api/addr/{id}/?noTxList=1',
        'Firo' => 'https://explorer.firo.org/insight-api-zcoin/addr/{id}/?noTxList=1',
        'Flux' => 'https://api.runonflux.io/explorer/balance?address={id}',
        'Conflux' => 'https://www.confluxscan.io/v1/account/{id}',
        'Ergo' => 'https://api.ergoplatform.com/api/v1/addresses/{id}/balance/total',
        'Callisto' => 'https://explorer.callisto.network/api?module=account&action=balance&address={id}',
        'BitcoinZ' => 'https://explorer.btcz.rocks/api/addr/{id}/?noTxList=1',
        'Aeternity' => 'https://mainnet.aeternity.io/v3/accounts/{id}',
        'Expanse' => '',
        'LiteCoin' => 'https://api.blockcypher.com/v1/ltc/main/addrs/{id}/balance',
        'Vertcoin' => 'https://chainz.cryptoid.info/explorer/address.summary2.dws?coin=vtc&id={id}',
        'Ton' => 'https://toncenter.com/api/v2/getAddressBalance?address={id}',
        'Dash' => 'https://api.blockcypher.com/v1/dash/main/addrs/{id}/balance'
    ]
];
