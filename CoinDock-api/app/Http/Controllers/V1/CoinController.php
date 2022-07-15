<?php

namespace App\Http\Controllers\V1;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\V1\Coin;

class CoinController extends Controller
{   
    public function index()
    {
        $coins = Coin::all()
            ->reduce(fn($carry, $coin) => $carry + [$coin->name=>$coin->coin_id], []);
        return response(
            [
                'message' => 'success',
                'results' => $coins
            ],
            Response::HTTP_OK
        ); 
    }
    
}