<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\{User, Wallet};
use App\Http\Resources\V1\CoinCardResource;
use Symfony\Component\HttpFoundation\Response;

class CoinCardController extends Controller
{
    public function index(User $user, Wallet $wallet)
    {  
        $coins = $user->wallets->map(function ($wallet) {
            return $wallet->coin;
        });
        if ($coins->isEmpty()) {
            return response(['message' => "Wallets are not found for this user"], Response::HTTP_BAD_REQUEST);
        } else {
            return response([
                'message' => 'success',
                'results' => CoinCardResource::collection($coins)->resolve(),

            ], Response::HTTP_OK,);
        }
    }
    
}
