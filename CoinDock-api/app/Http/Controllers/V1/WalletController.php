<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AddWalletRequest;
use App\Models\V1\User;
use App\Models\V1\Wallet;
use Symfony\Component\HttpFoundation\Response;

class WalletController extends Controller
{
    public function create(User $user, AddWalletRequest $request)
    {

        if ($user->wallets()->whereWalletId($request->wallet_id)->exists()) {
            return response([
                'message' => 'Wallet Already Added'
            ], Response::HTTP_BAD_REQUEST);
        }

        if(!Wallet::addWallet($user, $request)){
            return response([
                'message' => 'Wallet Cannot be added'
            ],Response::HTTP_BAD_REQUEST);
        }

        return response([
            'message' => 'Wallet Added Successfully'
        ],Response::HTTP_OK);
    }
}