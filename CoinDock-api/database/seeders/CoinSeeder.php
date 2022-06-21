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
        
        $coinNames = ['Bitcoin', 'Ethereum', 'Ethereum Classic', 'Ravencoin', 'Firo', 'Flux','Ergo', 'Callisto', 'BitcoinZ','LiteCoin','Ton','Dash','Aeternity', 'Expanse','Vertcoin','Conflux'];

        foreach ($coinNames as $coin) {
            Coin::create(['name' => $coin]);
        }
    }
}
