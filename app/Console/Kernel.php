<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        //清理无用过期数据
        $schedule->command("db:seed --class='Database\Seeders\Commands\ForceDeleteSeeder' --force")
            ->name('force_delete')
            ->withoutOverlapping()
            ->dailyAt('01:10');
        $schedule->command("db:seed --force")
            ->name('db_seed')
            ->withoutOverlapping()
            ->dailyAt('00:01');
        if(config('app.env')!='local'){
            //数据库备份
            $schedule->command("backup:run --only-db")
                ->name('backup_db')
                ->withoutOverlapping()
                ->dailyAt('02:00');
        }

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
