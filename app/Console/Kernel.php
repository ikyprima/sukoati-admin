<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands = [
        // ...
        \KitLoong\MigrationsGenerator\MigrateGenerateCommand::class,
    ];
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
    
        $this->load(__DIR__.'/Commands');
        $this->load(base_path("vendor/kitloong/laravel-migrations-generator/src"));
        require base_path('routes/console.php');
    }
}
