<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;

use App\Exceptions\ApiKeyException;
use App\Models\V1\Coin;
use App\Models\V1\HistoricalData;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
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


    protected string $xApiKey;

    protected array $encryptionKeys;

    protected string $range = '1HRS';

    public function __construct()
    {
        parent::__construct($this->name);

        $this->encryptionKeys = explode(',', config('coin.keys'));
        $this->xApiKey = current($this->encryptionKeys);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function historicalData(string $coinId, string $startDate, string $endDate)
    {
        $limit = config('coin.coin.limit');

        $baseURL = config('coin.coin.api_url') . config('coin.coin.realtime_url');
        
        $baseURLIdReplaced = str_replace(
            ['{coin1}', '{range}', '{start_date}', '{end_date}', '{limit}'],
            [$coinId, $this->range, $startDate, $endDate, $limit],
            $baseURL
        );
      
        $response = Http::withHeaders(['X-CoinAPI-Key' => $this->xApiKey])->get($baseURLIdReplaced);
        
        $responseLimit = Arr::first(Arr::get($response->headers(), 'x-ratelimit-remaining', null));
       
        info($responseLimit);
        if ($responseLimit <= 0) {
            info($responseLimit);
            info($this->xApiKey);
            $this->xApiKey = next($this->encryptionKeys);

            if(count($this->encryptionKeys) == array_search($this->xApiKey, $this->encryptionKeys) + 1) {
                $this->xApiKey = current($this->encryptionKeys);
            }
            
            return $this->historicalData($coinId, $startDate, $endDate);
        }

        return $response;
    }

    public function handleCoinData(string $coinId)
    {
        $endDate = Str::replace(' ', 'T', Carbon::now()->toDateTimeString());
        $startDate = Str::replace(' ', 'T', Carbon::now()->subYear(1)->toDateTimeString());
        $responses = json_decode($this->historicalData($coinId, $startDate, $endDate), true);
        
        foreach ($responses as $response){
            HistoricalData::updateOrCreate([
                'coin_date' => substr(Arr::get($response, 'time_period_end'), 0, strpos(Arr::get($response, 'time_period_end'), ".0000000Z")),
                'coin_id' => $coinId,
            ], 
            [ 'rate_close' => Arr::get($response, 'rate_close') ]
        );
        }
        
        $this->info("Data Fetched Successfully for {$coinId}");
    }

    public function handle()
    {
        $coins = Coin::select('coin_id')->whereIsCryptoAndStatus(1, 1);

        foreach($coins->lazy(10) as $coin) {
            $this->handleCoinData($coin->coin_id);
        }
        
        $this->info($this->getUsages());
    
        $this->info("Coins fetched successfully");
    }
}
