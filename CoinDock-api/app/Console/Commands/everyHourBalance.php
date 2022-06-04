<?php

namespace App\Console\Commands;

use App\Models\V1\Wallet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class everyHourBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balance:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will fetch the Balance Wallet balnce Hourly';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $wallet_instance = new Wallet();
        $wallets = Wallet::all();
        foreach ($wallets as $coin){

            $walletId = $coin->wallet_id;
            $coinId = $coin->coin_id;

            $baseUrl = $wallet_instance->basePath($coinId,$walletId);
            $response = Http::get($baseUrl);
            $bal = $wallet_instance->balance($response);

            Wallet::where('wallet_id',$walletId)->update(['balance'=>$bal]);
            

        }

        echo 'Wallet Balanced Updated..';



    }
}
