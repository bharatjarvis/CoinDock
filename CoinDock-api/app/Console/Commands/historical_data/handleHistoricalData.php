<?php

namespace App\Console\Commands\historical_data;

use App\Models\V1\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class handleHistoricalData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'historical_data:handle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches the historical data for every coin';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $user = new User();
        // $end_date = Carbon::now()->format('Y-m-d');
        // $end_date = $end_date."T".Carbon::now()->format('H:i:m');
        // $range = '7DAY';
        // $start_date = Carbon::now()->subYear(1);
        // $start_date  = str_replace(' ','T',$start_date);
        // $realTimeData = $user->commonDataRealTime('BTC',$range,$start_date,$end_date);
        // $assetArray = collect(json_decode($realTimeData));
    }
}
