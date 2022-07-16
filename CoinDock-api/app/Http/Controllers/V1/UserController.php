<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\V1\Auth\BuildPassportTokens;
use App\Http\Requests\V1\CreateUserRequest;
use App\Models\V1\Coin;
use App\Models\V1\User;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AccessTokenController
{
  use BuildPassportTokens;

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(CreateUserRequest $request)
  {
    $user = new User();
    $user->store($request);

    $response = $this->requestPasswordGrant($request);

    return response(
      [
        'status' => 'success', 'message' => 'Success! User registered.',
        'token' => $response['access_token']

      ],
      Response::HTTP_OK,
      [
        'Access-Token' => $response['access_token'],
        'Refresh-Token' => $response['refresh_token'],
        'Expires-In' => $response['expires_in'],
      ],
    );
  }

  public function totalBtc(User $user)
  {
    $coin = Coin::whereIsDefault(1)->first();
    return response([
      'message' => 'success',
      'results' => [
        'heading' => 'Total ' . $coin->coin_id,
        'balance' =>   $user->totalDefault(),
        'coin_id' => $coin->coin_id,
        'coin_name' => $coin->name,
        'img_url' => $coin->img_path
      ]
    ], Response::HTTP_OK);
  }
  public function primaryCurrency(User $user)
  {
    if ($user->wallets->isEmpty()) {
      return response([
        'message' => 'User Wallet Not Found'
      ],  Response::HTTP_BAD_REQUEST);
    }
    $result = ['heading' => 'Primary Currency'];
    $totalPrimaryCurrency = $user->totalPrimaryCurrency();
    return response([
      'message' => 'success',
      'results' => [
        'heading' => 'Primary Currency',
        'coin_name' => $totalPrimaryCurrency['coin_name'],
        'balance' => $totalPrimaryCurrency['balance']
      ]
    ], Response::HTTP_OK);
  }
  public function topPerformer(User $user)
  {
    if ($user->wallets->count() == 1) {
      return response([
        'message' => 'Success',
        'results' => [
          'heading' => 'Null'
        ]
      ], Response::HTTP_OK);
    }
    if ($user->wallets->isEmpty()) {
      return response([
        'message' => 'User Wallet Not Found'
      ], Response::HTTP_BAD_REQUEST);
    }

    $result = ['heading' => 'Top Performer'];
    $topPerformer = $user->topPerformer();
    return response([
      'message' => 'Success',
      'results' => [
        'heading' => 'Top performer',
        'coin_name' => $topPerformer['coin_name'],
        'coin_id' => $topPerformer['coin_id'],
        'balance' => $topPerformer['balance']
      ]

    ], Response::HTTP_OK);
  }

  public function lowPerformer(User $user)
  {
    if ($user->wallets->count() == 1) {
      return response([
        'message' => 'Success',
        'results' => [
          'heading' => 'Null'
        ]
      ], Response::HTTP_OK);
    }
    if ($user->wallets->isEmpty()) {
      return response([
        'message' => 'User Wallet Not Found'
      ], Response::HTTP_BAD_REQUEST);
    }
    $result = ['heading' => 'Low Performer'];
    $lowPerformer = $user->lowPerformer();

    return response([
      'message' => 'Success',
      'results' => [
        'heading' => 'Low performer',
        'coin_name' => $lowPerformer['coin_name'],
        'coin_id' => $lowPerformer['coin_id'],
        'balance' => $lowPerformer['balance']
      ]
    ], Response::HTTP_OK);
  }
}
