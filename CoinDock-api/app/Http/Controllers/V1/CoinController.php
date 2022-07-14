<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Http\Resources\V1\CoinResource;
use App\Models\V1\Coin;
use Illuminate\Http\Request;
=======
use App\Http\Requests\V1\CreateCoinRequest;
use App\Http\Requests\V1\UpdateCoinRequest;
use App\Http\Resources\V1\CoinResource;
use App\Models\V1\Coin;
>>>>>>> main
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
        return response([
            'message' => 'coins fetched succesfully',
<<<<<<< HEAD
            'result' => [
                'coins' => CoinResource::collection($coins)
            ], Response::HTTP_OK
        ];
=======
            'results' => [
                'coins' => CoinResource::collection($coins)
            ]
       ],Response::HTTP_OK);
>>>>>>> main
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCoinRequest $request)
    {

        $coin = Coin::create([
        'name'=>$request->name,
        'coin_id'=>$request->coin_id,
        'is_crypto'=>$request->is_crypto,
        'status'=>$request->status,
        'is_default'=>$request->is_default,
        'img_path'=>$request->img_path
        ]);

        $coin->save();
        return response([
<<<<<<< HEAD
                'message'=>'Coin Updated Successfully',
                'results'=>[
                    'coin'=>new CoinResource($coin)
                ]
            ],Response::HTTP_OK);
=======
            'message'=>'Coin Created Successfully',
            'results'=>[
                'coin'=>new CoinResource($coin)
            ]
        ],Response::HTTP_OK);
>>>>>>> main
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Coin $coin)
    {
<<<<<<< HEAD
        $coin = Coin::findOrFail($id)->first();
=======
>>>>>>> main
        return response([
            'message'=>'success',
            'results'=>[
                'coin'=>new CoinResource($coin)
            ]
<<<<<<< HEAD
        ],Response::HTTP_OK
        );

=======
            ],200);
>>>>>>> main
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCoinRequest $request, Coin $coin)
    {
        $coin->update($request->all());
        return response([
<<<<<<< HEAD
            'message'=>'Coin Updated Successfully',
            'coin'=>new CoinResource($coin)
        ],Response::HTTP_OK);
=======
            'message' => 'Coin Updated Successfully',
            'results'=>[
                'coin' => new CoinResource($coin)
            ]
        ], Response::HTTP_OK);
>>>>>>> main
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Coin $coin)
    {
        $coin->delete();
        return response([
<<<<<<< HEAD
            'message'=>'Coin Deleted Successfully',
        ],Response::HTTP_OK);
=======
            'message' => 'Coin Deleted Successfully',
        ], Response::HTTP_OK);
    }

    public function acceptedAssets(){
        $acceptedAssets = Coin::whereStatus(1)->get();
        return $acceptedAssets;
>>>>>>> main
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
