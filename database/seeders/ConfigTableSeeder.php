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
            'key' => 'app_logo_url',
            'name' => 'APP应用图标',
            'description' => 'APP应用图标',
            'type'=>1,
            'itype'=>7,
            'value' => '',
        ]);

        Config::create([
            'key' => 'privacy_policy',
            'name' => '隐私政策',
            'description' => '隐私政策条款内容',
            'type'=>1,
            'itype'=>3,
            'value' => '# LaravelAdmin隐私政策
#### 隐私政策
隐私政策条款内容',
        ]);

        Config::create([
            'key' => 'markdown_public_access_keys',
            'name' => 'markdown内容公开访问KEYS',
            'description' => '通过"/open/markdown?key=privacy_policy"访问对应的markdown解析内容页面',
            'type'=>2,
            'itype'=>4,
            'value' => [
                'privacy_policy'
            ],
        ]);



    }


}
