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
        //$this->call(ParamTableSeeder::class); //接口文档参数说明
        //$this->call(ResponseTableSeeder::class); //接口文档响应说明
        //页面置灰功能
        \App\Models\Config::firstOrCreate(['key'=>'page_gray'],[
            'key' => 'page_gray',
            'name' => '页面灰色',
            'description' => '页面灰色显示',
            'value' => 0,
            'type'=>3,
            'itype'=>5
        ]);

        \App\Models\Config::firstOrCreate(['key'=>'crawler_jump_url'],[
            'key' => 'crawler_jump_url',
            'name' => '爬虫跳转地址',
            'description' => '识别到爬虫后跳转地址',
            'value' => '',
            'type'=>1,
            'itype'=>1
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
