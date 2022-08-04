<?php

namespace App\Console\Commands\historicalData;

use Illuminate\Console\Command;
use App\Models\V1\HistoricalData;

class DataDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'historicalData:purge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handles deletion of Historical data more than year';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return HistoricalData::whereDate('coin_date', '<=', now()->subYear(1))->delete();
    }
}
