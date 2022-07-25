<?php

namespace App\Console\Commands;
use Illuminate\Support\Str;

use App\Exceptions\ApiKeyException;
use App\Models\V1\Coin;
use App\Models\V1\HistoricalData;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

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

    

    public function historicalData($coinId,$range,$startDate,$endDate,$encryptionKey)
    {
        $baseURL = config('coin.coin.api_url').config('coin.coin.realtime_url');
        $baseURLIdReplaced = str_replace(
            ['{coin1}', '{range}', '{start_date}', '{end_date}'],
            [$coinId, $range, $startDate, $endDate],
            $baseURL
        );

        try {
            $response = Http::withHeaders(
                ['X-CoinAPI-Key' => $encryptionKey]
                )->get($baseURLIdReplaced);
            
            return $response;
        } catch (\Throwable $th) {
            throw new ApiKeyException('Server down, try again after some time', Response::HTTP_BAD_REQUEST);
        }
    }

    public function handleCoinData($acceptedCoin,$encryptionKey)
    {
        $range = '1HRS';
        $endDate = str_replace(' ', 'T', Carbon::now()->toDateTimeString());
        $startDate = str_replace(' ', 'T', Carbon::now()->subYear(1)->toDateTimeString());
        $count = 0;
        $responses = json_decode($this->historicalData($acceptedCoin, $range, $startDate, $endDate, $encryptionKey));
        foreach($responses as $response) {    
            HistoricalData::updateOrCreate([
                'coin_id' => $acceptedCoin,
                'coin_date' => Str::substr($response->time_period_end,0,10),
                'time' => Str::substr($response->time_period_end,11,8),
                'rate_close' => $response->rate_close,
            ]);
        }
        echo "base case completed";
        for($i=0;$i<=91;$i++){
            $lastRow = DB::table('historical_data')->orderBy('id', 'DESC')->first();
            $lastRowDate = $lastRow->coin_date.'T'.$lastRow->time;
            $responses = json_decode($this->historicalData( $acceptedCoin, $range, $lastRowDate, $endDate,$encryptionKey));
            foreach($responses as $response) {    
                HistoricalData::updateOrCreate([
                    'coin_id' => $acceptedCoin,
                    'coin_date' => Str::substr($response->time_period_end,0,10),
                    'time' =>Str::substr($response->time_period_end,11,8),
                    'rate_close' => $response->rate_close,
                ]);
            }
            $count++;    
            echo "\n dONE ".$acceptedCoin." ".$count;    
        }
        echo "\n Data Fetched Successfully for ".$acceptedCoin;
    }


    public function handle(){
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
