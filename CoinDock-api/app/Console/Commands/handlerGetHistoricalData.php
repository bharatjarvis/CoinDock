<?php

namespace App\Console\Commands;

use App\Models\V1\HistoricalData;
use App\Models\V1\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class handlerGetHistoricalData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'history:coins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){
        $acceptedCoins = config('coin.accepted_coins');
        foreach($acceptedCoins as $acceptedCoin){
            $this->handleCoinData($acceptedCoin);
        }
        echo " Data Fetched for all coins";
    }

    
    public function handleCoinData($acceptedCoin)
    {
        $user = new User();
        $range = '1HRS';
        $endDate = str_replace(' ', 'T', Carbon::now()->toDateTimeString());
        $startDate = str_replace(' ', 'T', Carbon::now()->subYear(1)->toDateTimeString());
        $count = 0;
        $responses = collect($user->historicalData( $acceptedCoin, $range, $startDate, $endDate));
        foreach($responses as $response) {    
            HistoricalData::Create([
                'coin_id' => $acceptedCoin,
                'coin_date' => $response->time_period_end,
                'rate_close' => $response->rate_close,
            ]);
        }
        echo "base case completed\n";
        for($i=0;$i<=91;$i++){
            $lastRow = DB::table('historical_data')->orderBy('id', 'DESC')->first();
            $lastRowDate = substr($lastRow->coin_date, 0, strpos($lastRow->coin_date, ".0000000Z"));
            $responses = collect($user->historicalData( $acceptedCoin, $range, $lastRowDate, $endDate));
            foreach($responses as $response) {    
                HistoricalData::Create([
                    'coin_id' => $acceptedCoin,
                    'coin_date' => $response->time_period_end,
                    'rate_close' => $response->rate_close,
                ]);
            }
            $count++;  
            echo $count." Getting Data".$acceptedCoin."\n";         
        }
        echo "\n Data Fetched Successfully for ".$acceptedCoin;
    }


}
