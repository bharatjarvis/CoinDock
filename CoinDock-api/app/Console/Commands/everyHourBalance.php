<?php

namespace App\Console\Commands;

use App\Models\V1\RecoveryKey;
use App\Models\V1\Wallet;
use Illuminate\Console\Command;

class everyHourBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hourly:balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will fetch the Balance Wallet balnce Hourly';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $recoveryKeyList = RecoveryKey::all();




    }
}
