<?php

namespace App\Console;


use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\FetchDataCommand; // Import your custom command class


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
 
       protected function schedule(Schedule $schedule)
    {
        $schedule->command('app:fetch-data-command')->daily();
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

    protected $commands = [
        Commands\FetchDataCommand::class,
    ];



    // protected function commands()
    // {
    //     $this->load(__DIR__ . '/Commands');

    //     // Register your custom command
    //     $this->app->singleton('command.app:fetch-data-command', function ($app) {
    //         return new FetchDataCommand();
    //     });

    //     $this->commands([
    //         'command.app:fetch-data-command',
    //     ]);
    // }
}