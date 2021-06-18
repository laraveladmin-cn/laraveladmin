<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationTableSeeder extends Seeder
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
        DB::table('notifications')->truncate(); //用户表
        User::find(1)->notify(new \App\Notifications\Message(1,'安装提醒','恭喜你成功安装好系统','/notification/edit'));






    }
}
