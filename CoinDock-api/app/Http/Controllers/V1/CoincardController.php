<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\V1\User;
use App\Models\V1\{Wallet, Coin};
use App\Http\Resources\V1\coinCardResource;


class CoincardController extends Controller
{
    public function coinCard(User $user)
    {
        $coins = $user->wallets->map(function ($wallet) {
            return $wallet->coin;
        });
        if ($coins->isEmpty()) {
            return response(['message' => 'User have empty data'], 400);
        } else {
            return response([
                'message' => 'success',
                'results' => coinCardResource::collection($coins)->resolve(),

            ], 200);
        }
    }
}
