<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CoinResource;
use App\Models\V1\Coin;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coins = Coin::all();
        return [
            'message' => 'coins fetched succesfully',
            'result' => [
                'coins' => CoinResource::collection($coins)
            ], Response::HTTP_OK
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $coin=Coin::create([
            'name'=>$request->name
        ]);

        return response([
                'message'=>'Coin Updated Successfully',
                'results'=>[
                    'coin'=>new CoinResource($coin)
                ]
            ],Response::HTTP_OK);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $coin = Coin::findOrFail($id)->first();
        return response([
            'message'=>'success',
            'results'=>[
                'coin'=>new CoinResource($coin)
            ]
        ],Response::HTTP_OK
        );

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $coin = Coin::whereId($id)->update(['name'=>$request->name]);
        return response([
            'message'=>'Coin Updated Successfully',
            'coin'=>new CoinResource($coin)
        ],Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Coin::whereId($id)->delete();
        return response([
            'message'=>'Coin Deleted Successfully',
        ],Response::HTTP_OK);
    }


    //Returning the Coins that we are accepting
    public function acceptedAssets(){
        
        $coin = new Coin();
        return response([
            'message'=>'Success',
            'results'=>[
                'coins'=>CoinResource::collection($coin->acceptedAssets())
            ]
        ],Response::HTTP_OK);
    }


    //Conversions that we are accepting
    public function currencyConversions(){
        $coin = new Coin();
        return response([
            'message'=>'Success',
            'results'=>[
                'coins'=>CoinResource::collection($coin->currencyConversions())
            ]
        ],Response::HTTP_OK);
    }


    //Crypto coins that we are accepting
    public function acceptedCryptoCoins(){
        $coin = new Coin();
        return response([
            'message'=>'Success',
            'results'=>[
                'coins'=>CoinResource::collection($coin->acceptedCryptoCoins())
            ]
        ],Response::HTTP_OK);
    }

}
