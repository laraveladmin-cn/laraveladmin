<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \App\Models\User;

class UserTableSeeder extends Seeder
{
    protected $bindModel='App\User';
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        //初始化数据表
        DB::table('users')->truncate(); //用户表
        //ID:1 创建一个超级管理员用户
        User::create([
            'uname'=>config('laravel_admin.admin_user_name'),
            'name'=>config('app.name'),
            'password'=>strval(config('laravel_admin.admin_password')),
            'mobile_phone'=>13699411148,
            'email'=>'214986304@qq.com',
            'status'=>1
        ]);
    }
}
