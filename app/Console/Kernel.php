<?php

namespace App\Console;

use App\Services\VoteService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use function App\Helpers\sendDailyVoteSummary;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $voteService = new VoteService(); // Assume you have this service
            $totals = $voteService->getVoteTotals();
    
            // Use the helper function
            sendDailyVoteSummary($totals['dailyTotals'], $totals['overallTotals']);
            
        })->dailyAt('23:59'); //use 24 hour format
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
