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
        $has = collect(DB::connection('schema')->select($sql))->first();
        if(!$has){
            $sql = 'CREATE DATABASE `'.$database.'` CHARACTER SET utf8';
            DB::connection('schema')->statement($sql);
        }

    }
}
