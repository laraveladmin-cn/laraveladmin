<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class CheckDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $database = env('DB_DATABASE','forge');
        $sql = 'SELECT * FROM information_schema.SCHEMATA WHERE SCHEMA_NAME="'.$database.'" LIMIT 1';
        $has = false;
        try {
            $has = collect(DB::connection('schema')->select($sql))->first();
        }catch (\Exception $exception){
            $this->command->warn('请检查连接数据库用户是否有读取schema数据库权限!');
        }
        if(!$has){
            $sql = 'CREATE DATABASE `'.$database.'` CHARACTER SET utf8';
            try{
                DB::connection('schema')->statement($sql);
            }catch (\Exception $exception){
                $this->command->warn('创建'.$database.'数据库失败!');
            }
        }

    }
}
