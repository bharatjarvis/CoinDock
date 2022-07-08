<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AddWalletRequest;
use App\Models\V1\User;
use App\Models\V1\Wallet;
use Symfony\Component\HttpFoundation\Response;

class WalletController extends Controller
{
    public function create(User $user, AddWalletRequest $request){
        $wallet = new Wallet();

        $walletId = $request->wallet_id;
        $walletCheck = Wallet::whereWalletId($walletId)->first();

        if ($walletCheck) {
            return response([
                'message' => 'Wallet Already Added'
            ], Response::HTTP_CONFLICT);
        }
        
        else if(!$wallet->addWallet($user ,$request)){
            return response([
                'message'=>'Wallet Cannot be added '
            ],Response::HTTP_CONFLICT);
        }

        return response([
            'message'=>'Wallet Added Successfully '
        ],Response::HTTP_OK);
    }
}
