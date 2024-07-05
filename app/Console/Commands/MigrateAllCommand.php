<?php

namespace App\Console\Commands;

use App\Console\BaseCommand;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class MigrateAllCommand extends BaseCommand
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
    protected $description = 'Execute all migration files';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $directories = Storage::disk('migrations')->allDirectories();
        if(!$directories){
            $directories = $this->getAllDirectories(database_path('migrations'));
        }
        $this->call('migrate',['--force'=>true]);
        collect($directories)->each(function ($dir){
            $this->call('migrate',['--force'=>true,'--path'=>'database/migrations/'.$dir]);
        });
    }

    public function getAllDirectories($directory) {
        $directories = [];
        $scannedItems = scandir($directory);
        foreach ($scannedItems as $item) {
          if (is_dir($directory . DIRECTORY_SEPARATOR . $item) && $item != '.' && $item != '..') {
            $directories[] =  $item;
          }
        }
      
        return $directories;
      }

}
