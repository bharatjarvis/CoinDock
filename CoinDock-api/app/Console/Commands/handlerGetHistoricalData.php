<?php

namespace App\Console\Commands;

use App\Exceptions\ApiKeyException;
use App\Models\V1\HistoricalData;
use App\Models\V1\User;
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

    

    public function historicalData(string $coinId, string $range, string $startDate, string $endDate): array
    {
        $baseURL = config('coin.coin.api_url') . config('coin.coin.realtime_url');
        $baseURLIdReplaced = str_replace(
            ['{coin1}', '{range}', '{start_date}', '{end_date}'],
            [$coinId, $range, $startDate, $endDate],
            $baseURL
        );

        try {
            $response = Http::withHeaders(
                ['X-CoinAPI-Key' => config('coin.coin.api_key')]
                )->get($baseURLIdReplaced);
            return json_decode($response);
        } catch (\Throwable $th) {
            throw new ApiKeyException('Server down, try again after some time', Response::HTTP_BAD_REQUEST);
        }
    }

    public function handle(){
        $encryptionKeys = config('coin.keys');
        $encryptionKeys= explode(',',$encryptionKeys);
        echo collect($encryptionKeys);
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
