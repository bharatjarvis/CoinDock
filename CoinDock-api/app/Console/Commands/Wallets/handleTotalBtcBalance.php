<?php

namespace App\Console\Commands\Wallets;

use App\Models\V1\User;
use App\Models\V1\Wallet;
use Doctrine\Inflector\Rules\Word;
use Illuminate\Console\Command;
class handleTotalBtcBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Artisan command to send daily messages';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(User $user)
    {
      //updating totalbtc balance
      $totalCoinBtc =new Wallet();
        
      echo $totalCoinBtc->totalBtc($user);

    }
}
// $totalCoinBtc =new Wallet();
// return   $totalCoinBtc->totalBtc($user);