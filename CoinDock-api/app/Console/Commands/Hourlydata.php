<?php

namespace App\Console\Commands;
use App\Models\V1\Coin;
use Illuminate\Support\Str;
use App\Models\V1\HistoricalData;
use App\Console\Commands\handlerGetHistoricalData;
use Carbon\Carbon;
use Illuminate\Console\Command;


class Hourlydata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:hourly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handleCoinData($acceptedCoin,$encryptionKey)
    {
        $range = '1HRS';
        $endDate = str_replace(' ', 'T', Carbon::now()->toDateTimeString());
        $startDate = str_replace(' ', 'T', Carbon::now()->subHour(1)->toDateTimeString());
        $handleGetHistoricalData = new handlerGetHistoricalData();
        $responses = json_decode($handleGetHistoricalData->historicalData($acceptedCoin, $range, $startDate, $endDate, $encryptionKey));
        foreach($responses as $response) {    
            HistoricalData::updateOrCreate([
                'coin_id' => $acceptedCoin,
                'coin_date' => Str::substr($response->time_period_end,0,10),
                'time' => Str::substr($response->time_period_end,11,8),
                'rate_close' => $response->rate_close,
            ]);
        }
        echo "\n Data Fetched Successfully for ".$acceptedCoin;
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $acceptedCoins = Coin::select('coin_id')->whereIsCrypto(1)->whereStatus(1)->pluck('coin_id');
        $encryptionKeys = config('coin.keys');
        $encryptionKeys= collect(explode(',',$encryptionKeys));
        for($i=0;$i<count($encryptionKeys);$i++){
            for($j=0;$j<count($acceptedCoins);$j++){
                if($i==$j){
                    $this->handleCoinData($acceptedCoins[$i],$encryptionKeys[$j]);
                }
            }
        }
        echo " Done for all coins";
    }
    
}
