<?php

namespace App\Console\Commands\Coins;

use App\Models\V1\Coin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class handleCoins extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coins:handle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will fetch the coins from the coinapi.io';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        //fetching coins and insering the coins if they were not in our database


        // $AssetsUrl = config('assets.coin_api.base_path').config('assets.coin_api.assets_path');
        // $assets = Http::withHeaders(['X-CoinAPI-Key'=>config('assets.coin_api.key')])
        // ->get($AssetsUrl);

        // $assetArray = json_decode($assets);
        // //Inserting Coins That we have fetched from the Api
        // foreach ($assetArray as $asset){
        //     Coin::create([
        //         'coin_id'=>$asset->asset_id,
        //         'name'=>$asset->name,
        //         'is_crypto'=>$asset->type_is_crypto
        //     ]);
        // }




        //Updating Accepting coins list
        // $coins = Coin::all();
        // $acceptedAssets = array_keys(config('assets.accepted_coins'));

        // foreach ($acceptedAssets as $acceptedAsset){
        //     foreach($coins as $coin){
        //         if($coin->name == $acceptedAsset){
        //             $coin->update(['status'=>1]);
        //         }
        //     }
        // }



        //Updating CFX name as Conflux
        // foreach ($coins as $coin){
        //         if($coin->name =='CFX'){
        //             $coin->update(['name'=>'Conflux']);
        //         }
        // }


        //Inserting Image paths for every image
        //     $assetImagesUrl = config('assets.coin_api.base_path') . config('assets.coin_api.asset_images');

        //     $assetImages = Http::withHeaders(['X-CoinAPI-Key' => config('assets.coin_api.key')])
        //         ->get($assetImagesUrl);
        //     $assetImagesArray = json_decode($assetImages);
        //     foreach ($assetImagesArray as $assetImage) {
        //         foreach ($coins as $coin) {
        //             if ($coin->coin_id == $assetImage->asset_id) {
        //                 if ($coin->img_path == '') {
        //                     $coin->update(['img_path' => $assetImage->url]);
        //                 }
        //             }
        //         }
        //     }

    }
}
