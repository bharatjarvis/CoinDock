<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
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
                'coins' => $coins
            ], 200
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
                'coin'=>$coin
            ],200);
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
        return response(
          ['result'=>$coin],200
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
            'coin'=>$coin
        ],200);
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
        ],200);
    }


    //Returning the Coins that we are accepting
    public function acceptedAssets(){
        
        $acceptedAssets = Coin::whereStatus(1)->get();
        return response([
            'message'=>'Success',
            'results'=>[
                'coins'=>$acceptedAssets
            ]
        ],Response::HTTP_OK);
    }


    //Conversions that we are accepting
    public function acceptedConversions(){
        $acceptedAssets = Coin::whereStatus(1)->whereIsCrypto(0)->get();
        return response([
            'message'=>'Success',
            'results'=>[
                'coins'=>$acceptedAssets
            ]
        ],Response::HTTP_OK);
    }

}
