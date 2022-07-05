<?php

namespace App\Console\Commands\Coins;

use App\Models\V1\Coin;
use GrahamCampbell\ResultType\Success;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\LazyCollection;

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
        $AssetsUrl = config('assets.coin_api.base_path') . config('assets.coin_api.assets_path');
        $assets = Http::withHeaders(['X-CoinAPI-Key' => config('assets.coin_api.key')])
            ->get($AssetsUrl);

        $assetArray = json_decode($assets);

        //Inserting Coins That we have fetched from the Api
        foreach ($assetArray as $asset) {
            Coin::updateOrCreate(['coin_id' => !$asset->asset_id], [

                'coin_id' => $asset->asset_id,
                'name' => ($asset->name == 'CFX') ? ('Conflux') : ($asset->name),
                'is_crypto' => $asset->type_is_crypto

            ]);
        }




        //Making Accepted coins status as 1
        $acceptedAssets = array_keys(config('assets.accepted_coins'));

        foreach ($acceptedAssets as $acceptedAsset) {
            Coin::updateOrCreate(['name' => $acceptedAsset], ['status' => 1]);
        }


        //Inserting Image paths for every Coin
        $assetImagesUrl = config('assets.coin_api.base_path') . config('assets.coin_api.asset_images');
        $assetImages = Http::withHeaders(['X-CoinAPI-Key' => config('assets.coin_api.key')])
            ->get($assetImagesUrl);
        $assetImagesArray = json_decode($assetImages);

        foreach ($assetImagesArray as $assetImage) {
            Coin::updateOrCreate(['coin_id' => $acceptedAsset->asset_id], ['img_path' => $assetImage->url]);
        }


        $this->info('Coins Updated ');
        return Command::SUCCESS;
    }
}
