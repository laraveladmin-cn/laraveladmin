<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class FeatureTableSeeder extends Seeder
{
    protected $bindModel='App\Models\Feature';
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $class = $this->bindModel;
        $json_data=<<<'JSON'
[{"id":1,"name":"权限管理","icon":"fa-sitemap","color":"#00c0ef","description":"内置基于权限系统，已将路由、菜单进行绑定。","created_at":"2020-11-26 19:33:56","updated_at":"2020-11-26 23:46:29","deleted_at":null},{"id":2,"name":"统一API","icon":"fa-bolt","color":"#00a65a","description":"后台为web及移动端提供统一,通用,简洁的纯json数据接口,实现前后端分离","created_at":"2020-11-26 22:56:21","updated_at":"2020-11-26 23:44:14","deleted_at":null},{"id":3,"name":"用户管理","icon":"fa-users","color":"#f39c12","description":"后台用户,前端用户,注册登录忘记密码及相关权限管理","created_at":"2020-11-26 23:47:53","updated_at":"2020-11-26 23:47:53","deleted_at":null},{"id":4,"name":"操作日志","icon":"fa-mouse-pointer","color":"#dd4b39","description":"记录相关请求日志,方便操作记录跟踪.记录包括提交的参数及响应结果","created_at":"2020-11-26 23:50:54","updated_at":"2020-11-26 23:50:54","deleted_at":null}]
JSON;
        $data = json_decode($json_data,true);
        $class::insertReplaceAll($data);
    }
}
