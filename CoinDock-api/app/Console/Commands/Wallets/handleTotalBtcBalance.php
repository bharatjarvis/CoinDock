<?php

namespace App\Console\Commands\Wallets;

use App\Models\V1\User;
use App\Models\V1\Wallet;
use Doctrine\Inflector\Rules\Word;
use GuzzleHttp\Psr7\Message as Psr7Message;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Message;
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
    public function handle()
    {
      Message::daily('total-coins',function($user)
      {
        $total_balance = json_decode($user);
        $user_id = $total_balance->user_id;
        $coin_id = $total_balance->coin_id;
        $this->totalBtc($user_id,$coin_id);
          
      });

    }

     public function totalBtc($user_id,$coin_id)
     {

        return redirect()->action(
         'CoinsController@totalBtc',[

           'userId' =>$user_id,
           'coinId'=>$coin_id,
         ]);
     }

}
