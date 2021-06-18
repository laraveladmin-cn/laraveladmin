<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ConfigTableSeeder::class); //系统配置安装
        $this->call(MenuTableSeeder::class); //菜单数据安装
        $this->call(RoleTableSeeder::class); //角色数据安装
        $this->call(MenuRoleTableSeeder::class); //角色对应菜单安装
        $this->call(UserTableSeeder::class); //初始用户安装
        $this->call(AdminTableSeeder::class); //初始后台用户安装
        $this->call(AdminRoleTableSeeder::class); //后台用户添加角色安装

        $this->call(BankTableSeeder::class); //银行数据
        $this->call(ClassifyTableSeeder::class); //险种分类
        $this->call(PclassifyTableSeeder::class); //险种分组
        $this->call(YearTableSeeder::class); //年期
        $this->call(ProductSeeder::class); //产品相关数据
    }
}
