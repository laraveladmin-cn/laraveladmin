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
        //$this->call(TechnologyTableSeeder::class);
        //$this->call(FeatureTableSeeder::class);

    }


}
