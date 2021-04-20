<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        //初始化数据表
        DB::table('roles')->truncate(); //角色表
        //ID:1
        Role::create([
            'name'=>trans('Superadministrator'), //超级管理员
            'description' => trans('Have all operation permissions.') //拥有所有操作权限。
        ]);
    }
}
