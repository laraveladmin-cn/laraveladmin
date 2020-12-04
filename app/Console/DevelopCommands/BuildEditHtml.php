<?php

namespace App\Console\DevelopCommands;

use Illuminate\Console\Command;

class BuildEditHtml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:edit.html';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '编译生成前端入口文件edit.html';

    protected $fileName = 'edit.html';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $indexHtml = view('edit')->render();
        file_put_contents(public_path($this->fileName),$indexHtml);
    }
}
