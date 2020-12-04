<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        //初始化数据表
        DB::table('admins')->truncate();
        //创建后台用户
        \App\Models\User::find(1)->admin()
        ->save(\App\Models\Admin::create([]));
    }
}
