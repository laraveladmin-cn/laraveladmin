<?php
namespace Database\Seeders;
use App\Facades\Option;
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


        $this->addVersion();
    }

    /**
     * 增加系统版本号
     */
    protected function addVersion(){
        $system_version_no = Option::get('system_version_no');
        if($system_version_no){
            $arr = explode('.',$system_version_no);
            $arr[count($arr)-1] +=1;
            $system_version_no = implode('.',$arr);
            Option::set('system_version_no',$system_version_no);
        }
    }


}
