<?php

namespace App\Console\Commands\Wallets;

use App\Models\V1\Coin;
use App\Models\V1\Wallet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class HandleWalletBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wallet:handle_balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will refresh wallet table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $wallets = Wallet::all();
        foreach ($wallets as $wallet){

            $baseUrl = $wallet->basePath($wallet->coin_id,$wallet->wallet_id);
            $coinName = Coin::whereId($wallet->coin_id)->first();
            $coinName = $coinName->name;

            //Fetching balance from basepath
            $response = Http::withHeaders(['X-CoinAPI-Key' => config('assets.coin_api.key')])
            ->get($baseUrl);
            $coins = $wallet->coins($response,$coinName);

            //converting balance to USD
            $balanceInUsd = $wallet->cryptoToUsd($coinName);


            //Updating Wallet 
            $wallet->balance=($coins*$balanceInUsd);
            $wallet->coins = $coins;
            $wallet->save();

        }

        $this->info('Wallet Balance Updated ');
        return Command::SUCCESS;

    }
}

