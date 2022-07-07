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
        //fetching coins from API
        $AssetsUrl = config('assets.coin_api.base_path') . config('assets.coin_api.assets_path');
        $assets = Http::withHeaders(['X-CoinAPI-Key' => config('assets.coin_api.key')])
            ->get($AssetsUrl);
        $assetArray = collect(json_decode($assets));

        //Coins that we are accepting
        $acceptedAssets = array_keys(config('assets.accepted_coins'));

        // // //Inserting Coins That we have fetched from the Api
        foreach ($assetArray->lazy(100) as $asset) {
            Coin::updateOrCreate([
                'coin_id' => $asset->asset_id], [
                'name' => ($asset->name == 'CFX') ? ('Conflux') : ($asset->name),
                'is_crypto' => $asset->type_is_crypto
            ]);

            Coin::whereIn('name', $acceptedAssets)->update(['status' => 1]);
        }

        $coins = Coin::all();


        // //Inserting Image paths for Coins
        $assetImagesUrl = config('assets.coin_api.base_path') . config('assets.coin_api.asset_images');
        $assetImages = Http::withHeaders(['X-CoinAPI-Key' => config('assets.coin_api.key')])
            ->get($assetImagesUrl);
        $assetImagesArray = json_decode($assetImages);

        foreach ($assetImagesArray as $image){
            foreach ($coins as $coin){
                if($coin->coin_id == $image->asset_id){
                    $coin->update(['img_path'=>$image->url]);
                }
            }
        }
        
        $this->info('Coins Updated ');
        return Command::SUCCESS;
    }
}
