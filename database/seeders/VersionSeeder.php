<?php
namespace Database\Seeders;
use App\Facades\Option;
use App\Models\Config;
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
        //系统版本号
        Config::query()->firstOrCreate([
            'key' => 'system_version_no'
        ],[
            'key' => 'system_version_no',
            'name' => '系统版本号',
            'description' => '系统版本号',
            'value' => 'v1.0.0'
        ]);

        //百度统计代码
        Config::create([
            'key' => 'baidu_statistics_url'
        ],[
            'key' => 'baidu_statistics_url',
            'name' => '百度统计地址',
            'description' => '百度统计地址',
            'value' => ''
        ]);

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
