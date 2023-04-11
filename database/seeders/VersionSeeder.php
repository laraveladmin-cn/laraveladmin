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
        \App\Models\Config::firstOrCreate(['key'=>'privacy_policy_url'],[
            'key' => 'privacy_policy_url',
            'name' => '隐私条款',
            'description' => '隐私条款',
            'value' => '',
            'type'=>1,
            'itype'=>8
        ]);
        \App\Models\Config::firstOrCreate(['key'=>'wxconfig_official'],[
            'key' => 'wxconfig_official',
            'name' => '微信公众号分享配置',
            'description' => '微信公众号分享显示配置',
            'type'=>2,
            'itype'=>4,
            'value' => [
                'title'=>config('app.name'),
                'desc'=>config('app.name'),
                'imgUrl'=>config('app.url').'/dist/img/logo1.png'
            ]
        ]);
        \App\Models\Config::firstOrCreate(['key'=>'get_recommended_content_copy'],[
            'key' => 'get_recommended_content_copy',
            'name' => '获取推荐内容选项文案',
            'description' => '获取推荐内容选项文案',
            'type'=>1,
            'itype'=>2,
            'value' => ''
        ]);
        \App\Models\Config::firstOrCreate(['key'=>'use_write_tpl_id'],[
            'key' => 'use_write_tpl_id',
            'name' => '默认使用撰写提示语模板ID',
            'description' => '默认使用撰写提示语模板ID',
            'type'=>3,
            'itype'=>1,
            'value' => 0
        ]);
        \App\Models\Config::firstOrCreate(['key'=>'cue_word_id'],[
            'key' => 'cue_word_id',
            'name' => '默认聊天模板ID',
            'description' => '默认聊天模板ID',
            'type'=>3,
            'itype'=>1,
            'value' => 0
        ]);
        \App\Models\Config::firstOrCreate(['key'=>'robot_head_url'],[
            'key' => 'robot_head_url',
            'name' => '机器人聊天头像',
            'description' => '机器人聊天头像',
            'value' => '',
            'type'=>1,
            'itype'=>7
        ]);
        \App\Models\Config::firstOrCreate(['key'=>'complex_q'],[
            'key' => 'complex_q',
            'name' => '提出复杂问题',
            'description' => '提出复杂问题',
            'value' => '如何确定客户的保险需求?',
            'type'=>1,
            'itype'=>1
        ]);
        \App\Models\Config::firstOrCreate(['key'=>'better_q'],[
            'key' => 'better_q',
            'name' => '获得更好的答案',
            'description' => '获得更好的答案',
            'value' => '如何评估客户的风险承受能力?',
            'type'=>1,
            'itype'=>1
        ]);
        \App\Models\Config::firstOrCreate(['key'=>'creativity_q'],[
            'key' => 'creativity_q',
            'name' => '获得创意灵感',
            'description' => '获得创意灵感',
            'value' => '如何保持更新的保险知识?',
            'type'=>1,
            'itype'=>1
        ]);
        \App\Models\Config::firstOrCreate(['key'=>'privacy_policy'],[
            'key' => 'privacy_policy',
            'name' => '必有隐私政策',
            'description' => '必有隐私政策',
            'value' => '必有隐私政策',
            'type'=>1,
            'itype'=>3
        ]);
        \App\Models\Config::firstOrCreate(['key'=>'terms_of_use'],[
            'key' => 'terms_of_use',
            'name' => '必有使用条款',
            'description' => '必有使用条款',
            'value' => '必有使用条款',
            'type'=>1,
            'itype'=>3
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
