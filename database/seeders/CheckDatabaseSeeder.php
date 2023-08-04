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
        $connection = config('database.default');
        $driver =  config('database.connections.'.$connection.'.driver');
        $database = env('DB_DATABASE','forge');
        if($driver=='mysql'){
            $sql = 'SELECT * FROM information_schema.SCHEMATA WHERE SCHEMA_NAME= :database LIMIT 1';
        }elseif($driver=='pgsql'){
            $sql = "SELECT * FROM pg_database WHERE datname = :database LIMIT 1";
        }else{
            return;
        }

        $has = false;
        try {
            $has = collect(DB::connection($connection)->select($sql,['database'=>$database]))->first();
        }catch (\Exception $exception){
            $this->command->warn(trans('Check whether the connection IP Settings or the database user has access to read the schema database!'));//'请检查连接IP设置或数据库用户是否有读取schema数据库权限!'
            $this->command->error($exception->getMessage());
        }
        if(!$has){
            $default = config('database.default');
            $charset = config('database.connections.'.$default.'.charset');
            $sql = $driver=='pgsql'?'CREATE DATABASE "'.$database.'"':'CREATE DATABASE `'.$database.'`';
            if($charset){
                if($driver=='pgsql'){
                    $sql = $sql.' ENCODING \''.$charset.'\'';
                }else{
                    $sql = $sql.' CHARACTER SET "'.$charset.'"';
                }
            }
            $collation = config('database.connections.'.$default.'.collation');
            if($collation){
                $sql = $sql.' COLLATE "'.$collation.'"';
            }
            try{
                DB::connection($connection)->statement($sql);
            }catch (\Exception $exception){
                $this->command->warn(trans("Failed to create :attribute database!",['attribute'=>$database]));//'创建'.$database.'数据库失败!'
                $this->command->error($exception->getMessage());
            }
        }

    }
}
