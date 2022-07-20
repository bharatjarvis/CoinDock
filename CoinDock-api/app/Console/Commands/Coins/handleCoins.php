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
        $assetsUrl = config('coin.coin.api_url') . config('coin.coin.api_url.assets_path');
        $response = Http::withHeaders(['X-CoinAPI-Key' => config('coin.coin.api_url.key')])
            ->get($assetsUrl);
        $assetArray = collect(json_decode($response));

        //Coins that we are accepting
        $acceptedAssets = array_keys(config('assets.accepted_coins'));

        $defaultCoin = config('assets.default_coin');

        // // //Inserting Coins That we have fetched from the Api
        foreach ($assetArray->lazy(100) as $asset) {
            Coin::updateOrCreate([
                'coin_id' => $asset->asset_id], [
                'name' => ($asset->name == 'CFX') ? ('Conflux') : ($asset->name),
                'is_crypto' => $asset->type_is_crypto,
                'status' => $asset->name == $acceptedAssets ? true : false,
                'is_default' => $asset->name == $defaultCoin ? true : false
            ]);
        }

        // //Inserting Image paths for Coins
        $assetImagesUrl = config('coin.coin.api_url.base_path') . config('coin.coin.api_url.asset_images');
        $response = Http::withHeaders(['X-CoinAPI-Key' => config('coin.coin.api_url.key')])
            ->get($assetImagesUrl);
        $assetImagesArray = json_decode($response);

        foreach ($assetImagesArray as $image) {
            if($coin = Coin::whereCoinId($image->asset_id)->first()){
                $coin->update(['img_path'=>$image->url]);
            }
        }

        $this->info('Coins updated');
        return Command::SUCCESS;
    }
}