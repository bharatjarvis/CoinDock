<?php

namespace Database\Seeders;

use App\Models\V1\Coin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $coinNames = ['Bitcoin', 'Ethereum', 'Ethereum Classic', 'Ravencoin', 'Firo', 'Flux', 'Metaverse ETP', 'Ergo', 'Callisto', 'BitcoinZ', 'Monero', 'ZCash', 'LiteCoin', 'Grin', 'Ton', 'Dash'];

        foreach ($coinNames as $coin) {
            Coin::create(['name' => $coin]);
        }
    }
}
