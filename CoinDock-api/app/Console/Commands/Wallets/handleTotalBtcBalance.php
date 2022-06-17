<?php

namespace App\Console\Commands\Wallets;

use App\Http\Controllers\V1\CoinsController;
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

    $wallets = Wallet::all();
    $userIds =[];
    foreach ($wallets as $wallet){
      array_push($userIds,$wallet->user_id);
    }
    $userIds = array_unique($userIds);

    $walet = new Wallet();


    $userList= [];
    foreach($userIds as $userId){
      $user = User::whereId($userId)->first();
      array_push($userList,$user);
    }


    foreach ($userList as $user){
      $totalBtc = $wallet->totalBTC($user->id);

      echo $totalBtc." ";
    }

    


  }
}
