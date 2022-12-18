<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class TechnologyTableSeeder extends Seeder
{
    protected $bindModel='App\Models\Technology';
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $class = $this->bindModel;
        $json_data=<<<'JSON'
[{"id":1,"name":"laravel","url":"https:\/\/laravel.com\/","logo":"https:\/\/www.laraveladmin.cn\/dist\/img\/index\/laravel.jpg","description":"Laravel 是 Taylor Otwell 开发的一款基于 PHP 语言的 Web 开源框架，采用了 MVC 的架构模式","created_at":"2020-11-27 23:41:42","updated_at":"2020-11-27 23:41:42","deleted_at":null},{"id":2,"name":"docker","url":"https:\/\/www.docker.com\/","logo":"https:\/\/www.laraveladmin.cn\/dist\/img\/index\/docker.jpg","description":"Docker 是一个开源的应用容器引擎，让开发者可以打包他们的应用以及依赖包到一个可移植的镜像中，然后发布到任何流行的 Linux或Windows 机器上，也可以实现虚拟化。","created_at":"2020-11-27 23:43:16","updated_at":"2020-11-27 23:43:16","deleted_at":null},{"id":3,"name":"Git","url":"https:\/\/git-scm.com\/","logo":"https:\/\/cdn.jsdelivr.net\/npm\/@bootcss\/www.bootcss.com@0.0.32\/dist\/img\/git-guide.png","description":"git是一个分布式代码版本控制软件。      。","created_at":"2020-11-27 23:47:06","updated_at":"2020-11-27 23:47:06","deleted_at":null},{"id":4,"name":"Vue.js","url":"https:\/\/cn.vuejs.org\/index.html","logo":"https:\/\/cdn.jsdelivr.net\/npm\/@bootcss\/www.bootcss.com@0.0.32\/dist\/img\/vuejs.png","description":"Vue是一套用于构建用户界面的渐进式框架。与其它大型框架不同的是，Vue 被设计为可以自底向上逐层应用","created_at":"2020-11-27 23:47:52","updated_at":"2020-11-27 23:47:52","deleted_at":null},{"id":5,"name":"Bootstrap","url":"https:\/\/v4.bootcss.com\/","logo":"https:\/\/cdn.jsdelivr.net\/npm\/@bootcss\/www.bootcss.com@0.0.32\/dist\/img\/expo.png","description":"Bootstrap 是全球最受欢迎的前端开源工具库，它支持 Sass 变量和 mixin、响应式栅格系统、自带大量组件和众多强大的 JavaScript 插件。","created_at":"2020-11-27 23:49:57","updated_at":"2020-11-27 23:49:57","deleted_at":null},{"id":6,"name":"NPM","url":"https:\/\/www.npmjs.cn\/","logo":"https:\/\/cdn.jsdelivr.net\/npm\/@bootcss\/www.bootcss.com@0.0.32\/dist\/img\/npm.png","description":"NPM（node package manager）是 Node.js 世界的包管理器。NPM 可以让 JavaScript 开发者在共享代码、复用代码以及更新共享的代码上更加方便。","created_at":"2020-11-27 23:50:45","updated_at":"2020-11-27 23:50:45","deleted_at":null}]
JSON;
        $data = json_decode($json_data,true);
        $class::insertReplaceAll($data);
    }
}
