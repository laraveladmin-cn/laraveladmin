<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        //初始化数据表
        DB::table('admin_role')->truncate();
        \App\Models\Admin::find(1)->roles()->save(\App\Models\Role::find(1));
    }
}
