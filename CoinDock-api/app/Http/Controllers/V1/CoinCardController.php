<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\User;
use App\Http\Resources\V1\CoinCardResource;
use Symfony\Component\HttpFoundation\Response;

class CoinCardController extends Controller
{
    public function index(User $user)
    {
        $coins = $user->userAcceptedCoins();

        if ($coins->isEmpty()) {
            return response(['message' => "Wallets are not found for this user"], Response::HTTP_NOT_FOUND);
        } else {
            return response([
                'message' => 'success',
                'results' => CoinCardResource::collection($coins)->resolve(),

            ], Response::HTTP_OK);
        }
    }

}