<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CreateCoinRequest;
use App\Http\Requests\V1\UpdateCoinRequest;
use App\Http\Resources\V1\CoinResource;
use App\Models\V1\Coin;
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
            'results' => [
                'coins' => CoinResource::collection($coins)
            ]
       ],Response::HTTP_OK);
    }

    public function coinShortNames()
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
    public function show(Coin $coin)
    {
        return response([
            'message'=>'success',
            'results'=>[
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
            'results'=>[
                'coin' => new CoinResource($coin)
            ]
        ], Response::HTTP_OK);
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
        ], Response::HTTP_OK);
    }

    public function acceptedAssets(){
        $acceptedAssets = Coin::whereStatus(1)->get();
        return $acceptedAssets;
    }
}
