<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \App\Models\Config;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //初始化数据表
        DB::table('configs')->truncate(); //系统配置表

        //系统用户通用密码
        Config::create([
            'key' => 'common_password',
            'name' => 'Common password configuration',//'通用密码配置',
            'description' => 'Common password for all users, please set a relatively complex password',//'所有用户通用密码,请设置相对复杂密码',
            'value' => config('laravel_admin.admin_password')
        ]);

        //系统版本号
        Config::create([
            'key' => 'system_version_no',
            'name' => '系统版本号',
            'description' => '系统版本号',
            'value' => 'v1.0.0'
        ]);

        //百度统计代码
        Config::create([
            'key' => 'baidu_statistics_url',
            'name' => '百度统计地址',
            'description' => '百度统计地址',
            'value' => ''
        ]);

        //页面灰色
        Config::create([
            'key' => 'page_gray',
            'name' => '页面灰色',
            'description' => '页面灰色显示',
            'value' => 0,
            'type'=>3,
            'itype'=>5
        ]);

        Config::create([
            'key' => 'crawler_jump_url',
            'name' => '爬虫跳转地址',
            'description' => '识别到爬虫后跳转地址',
            'value' => '',
            'type'=>1,
            'itype'=>1
        ]);

        Config::create([
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
        Config::create([
            'key' => 'get_recommended_content_copy',
            'name' => '获取推荐内容选项文案',
            'description' => '获取推荐内容选项文案',
            'type'=>1,
            'itype'=>2,
            'value' => ''
        ]);

        Config::create([
            'key' => 'use_write_tpl_id',
            'name' => '默认使用撰写提示语模板ID',
            'description' => '默认使用撰写提示语模板ID',
            'type'=>3,
            'itype'=>1,
            'value' => 0
        ]);

        Config::create([
            'key' => 'cue_word_id',
            'name' => '默认聊天模板ID',
            'description' => '默认聊天模板ID',
            'type'=>3,
            'itype'=>1,
            'value' => 0
        ]);

        Config::create([
            'key' => 'robot_head_url',
            'name' => '机器人聊天头像',
            'description' => '机器人聊天头像',
            'value' => '',
            'type'=>1,
            'itype'=>7
        ]);

        Config::create([
            'key' => 'memory_session_length',
            'name' => '记忆会话条数',
            'description' => '记忆会话条数',
            'value' => 1,
            'type'=>3,
            'itype'=>6
        ]);
        Config::create([
            'key' => 'abstract_session_length',
            'name' => '摘要会话条数',
            'description' => '摘要会话条数',
            'value' => 1,
            'type'=>3,
            'itype'=>6
        ]);
        Config::create([
            'key' => 'abstract_content',
            'name' => '摘要总结文案',
            'description' => '摘要总结文案',
            'value' => 1,
            'type'=>1,
            'itype'=>2
        ]);
    }


}
