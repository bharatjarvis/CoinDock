<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\V1\Auth\BuildPassportTokens;
use App\Http\Requests\V1\CreateUserRequest;
use App\Http\Requests\V1\updateProfileRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\V1\Coin;
use App\Models\V1\User;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

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
    $userData = $user->store($request);

    $response = $this->requestPasswordGrant($request);

    return response(
      [
        'status' => 'success', 'message' => 'Success! User registered.'

      ],
      Response::HTTP_OK,
      [
        'Access-Token' => $response['access_token'],
        'Refresh-Token' => $response['refresh_token'],
        'Expires-In' => $response['expires_in'],
      ],
    );
  }

  public function updateProfile(User $user, updateProfileRequest $request)
  {
    $updatedUser = $user->updateProfile($user, $request);

    return response([
      'message' => 'Updated successfully',
      'results' => [
        'user' => new UserResource($updatedUser)
      ]
    ], Response::HTTP_OK);
  }

  //list of user titles 
  public function usersTitles()
  {

    return response([
      'message' => 'success',
      'results' => [
        'titles' => User::titles()
      ]
    ], Response::HTTP_OK);
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
    $totalPrimaryCurrency = $user->totalPrimaryCurrency();

    $image_path = Coin::select('img_path')->where('coin_id', '=', $totalPrimaryCurrency['coin_name'])->get();
    return response([
      'message' => 'success',
      'results' => [
        'heading' => 'Primary Currency',
        'coin_name' => $totalPrimaryCurrency['coin_name'],
        'balance' => $totalPrimaryCurrency['balance'],
        'img_url' => $image_path[0]['img_path']
      ]
    ], Response::HTTP_OK);
  }


  public function topPerformer(User $user)
  {
    if ($user->wallets->count() == 1) {
      return response([
        'message' => 'Success',
        'results' => null
      ], Response::HTTP_OK);
    }
    if ($user->wallets->isEmpty()) {
      return response([
        'message' => 'User Wallet Not Found'
      ], Response::HTTP_BAD_REQUEST);
    }
    $topPerformer = $user->topPerformer();
    $path = storage_path('app/public/images/uparrow.png');

    return response([
      'message' => 'Success',
      'results' => [
        'heading' => 'Top performer',
        'coin_name' => $topPerformer['coin_name'],
        'coin_id' => $topPerformer['coin_id'],
        'balance' => $topPerformer['balance'],
        'image_path' => $path
      ]

    ], Response::HTTP_OK);
  }



  public function lowPerformer(User $user)
  {
    if ($user->wallets->count() == 1) {
      return response([
        'message' => 'Success',
        'results' => null
      ], Response::HTTP_OK);
    }
    if ($user->wallets->isEmpty()) {
      return response([
        'message' => 'User Wallet Not Found'
      ], Response::HTTP_BAD_REQUEST);
    }
    $lowPerformer = $user->lowPerformer();
    $path = storage_path('app/public/images/downarrow.png');
    return response([
      'message' => 'Success',
      'results' => [
        'heading' => 'Low performer',
        'coin_name' => $lowPerformer['coin_name'],
        'coin_id' => $lowPerformer['coin_id'],
        'balance' => $lowPerformer['balance'],
        'image_path' => $path
      ]
    ], Response::HTTP_OK);
  }
}
