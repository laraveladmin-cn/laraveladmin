<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class MigrateAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '迁移所有文件';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $directories = Storage::disk('migrations')->allDirectories();
        $this->call('migrate',['--force'=>true]);
        collect($directories)->each(function ($dir){
            $this->call('migrate',['--force'=>true,'--path'=>'database/migrations/'.$dir]);
        });
    }

}
