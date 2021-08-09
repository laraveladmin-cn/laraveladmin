<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class VersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MenuTableSeeder::class); //菜单数据安装
        $this->call(ParamTableSeeder::class); //接口文档参数说明
        $this->call(ResponseTableSeeder::class); //接口文档响应说明


    }


}
