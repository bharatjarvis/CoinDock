<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;

use App\Http\Controllers\V1\UserController;
use App\Models\V1\Coin;
use App\Models\V1\User;
use Illuminate\Http\Request;
use App\Models\V1\Wallet;
use Illuminate\Database\Eloquent\Model;


class CoinsController extends Controller
{
  public function totalBtc(User $user)
  {
    $wallet = new Wallet();
    return $wallet->totalBtc($user);
  }
  public function currencyConverter(User $user)
  {
    $wallet = new Wallet();
    return $wallet->currencyConverter($user);
  }

  public function topPerformer(User $user, Wallet $wallet)
  {
    $balanceName = new Wallet();
    return $balanceName->topPerformer($user, $wallet);
  }
  public function lowPerformer(User $user, Wallet $wallet)
  {
    $balanceName = new Wallet();
    return $balanceName->lowPerformer($user, $wallet);
  }
}
