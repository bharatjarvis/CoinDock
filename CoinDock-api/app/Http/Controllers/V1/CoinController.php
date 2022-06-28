<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
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
                'coins' => $coins
            ], 200
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40000000000);
        //$acceptedCoins = config('coinapi.accepted_coins');
        $coins = Http::withHeaders([
                'X-CoinAPI-Key' => config('coinapi.key'),
                'connect_timeout' => 5,
                'timeout' => 5,
                'read_timeout' => 5,
            ])
            ->get(config('coinapi.base_path') . config('coinapi.assets_path'));
        // $coins = Http::get(config('coinapi.base_path').config('coinapi.assets_path').'?apikey='.config('coinapi.key'));

        return $coins;
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
            ['result' => $coin],
            200
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
        $coin = Coin::whereId($id)->update(['name' => $request->name]);
        return response([
            'message' => 'Coin Updated Successfully',
            'coin' => $coin
        ], 200);
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
            'message' => 'Coin Deleted Successfully',
        ], 200);
    }
}
