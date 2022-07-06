<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CreateCoinRequest;
use App\Http\Requests\V1\UpdateCoinRequest;
use App\Http\Resources\V1\CoinResource;
use App\Models\V1\Coin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
            ], 200
        ];
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
            'message'=>'Coin Created Successfully',
            'result'=>[
                'coin'=>new CoinResource($coin)
            ]
        ],200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Coin $coin)
    {
        return response([
            'message'=>'success',
            'result'=>[
                'coin'=>new CoinResource($coin)
            ]
            ],200);
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
            'message' => 'Coin Updated Successfully',
            'result'=>[
                'coin' => new CoinResource($coin)
            ]
        ], 200);
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
            'message' => 'Coin Deleted Successfully',
        ], 200);
    }
}
