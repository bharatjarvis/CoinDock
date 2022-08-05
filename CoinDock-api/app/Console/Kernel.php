<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('passport:purge')->hourly();

        $schedule->command('wallet:handle_balance')->everyFiveMinutes()->runInBackground()->withoutOverlapping();

        $schedule->command('coins:handle')->monthly()->runInBackground()->withoutOverlapping();

        $schedule->command('historicalData:fetch ')->hourly()->runInBackground()->withoutOverlapping();

        $schedule->command('historicalData:fetch --yearly-data')->yearly()->runInBackground()->withoutOverlapping();

        $schedule->command('historicalData:delete ')->yearly()->runInBackground()->withoutOverlapping();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}