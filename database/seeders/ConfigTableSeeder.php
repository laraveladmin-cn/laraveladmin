<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \App\Models\Config;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //初始化数据表
        DB::table('configs')->truncate(); //系统配置表

        //系统用户通用密码
        Config::create([
            'key' => 'common_password',
            'name' => 'Common password configuration',//'通用密码配置',
            'description' => 'Common password for all users, please set a relatively complex password',//'所有用户通用密码,请设置相对复杂密码',
            'value' => config('laravel_admin.admin_password')
        ]);




    }


}
