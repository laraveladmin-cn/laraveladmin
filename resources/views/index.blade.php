<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>{{$app_name}}</title>
    <meta name="keywords" content="{{$app_name}},{{$app_name}}官网,{{$app_name}}单页面应用,{{$app_name}}前后端分离,Laravel后台管理系统,{{$app_name}}企业网站,{{$app_name}}要怎么用,{{$app_name}}文档,{{$app_name}}Swoole,Laravel,laravel-swoole,docker,官网:https://www.laraveladmin.cn" />
    <meta name="description" content="{{$app_name}},简洁、直观、强悍的前端后端开发框架，让全栈开发更迅速的SPA单页面应用。企业官网:https://www.laraveladmin.cn" />
    <link rel="icon" type="image/x-icon" href="{{config('laravel_admin.logo')}}">
    <link href="/css/app.css?{{$time_str}}" rel="stylesheet">
    <script src="{{config('app.url').getRoutePrefix(config('laravel_admin.web_api_model'))}}/open/config?script=AppConfig{{$time_str}}" type="application/javascript"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="hide">
    <h1>LaravelAdmin</h1>
    <center>
        <img src="https://www.laraveladmin.cn/dist/img/logo1.png" data-origin="httpw://www.laraveladmin.cn/dist/img/logo1.png" alt="Logo" style="width: 200px" />
    </center>
    <h4>介绍</h4>
    <p><code>laravel-admin</code>是一个可以快速帮你构建后台管理的工具，它提供的页面组件和表单元素等功能，能帮助你使用很少的代码就实现功能完善的后台管理功能。(QQ群: 391528810)
        <a href="http://demo.laraveladmin.cn">Demo</a> || <a href="http://www.laraveladmin.cn/home/index">阅读文档</a></p>
    <h4>特点</h4>
    <ul>
        <li>Laravel+Vue组合</li>
        <li>SPA单页面应用</li>
        <li>前后端分离,后台只提供API接口,前端负责视图渲染</li>
        <li>开箱即用的laravel后台管理系统</li>
        <li>海量Vue组件直接拿来即用</li>
    </ul>
    <h2>截图</h2>
    <p><img src="https://www.laraveladmin.cn/storage/uploads/images/2020/12/05/kg3F2blsJISs6GbyFdmItHU7VKGLPx4zUIrPS0H6.jpeg" alt="laravel-admin" /></p>
    <h4>软件架构</h4>
    <p>基于laravel框架实现前后端分离的单页面应用架构</p>
    <p>使用相关技术:vue+bootstrap+phpswoole+docker+laravel</p>
    <h3>Windows环境安装请查看 <a href="README_windows.md">Windows安装</a></h3>
    <h4>安装前准备</h4>
    <ol>
        <li>提前安装好git(整套部署流程使用git方式部署,请依照文档通过git clone命令安装)</li>
    </ol>
    <h4>安装教程</h4>
    <ol>
        <li>下载代码</li>
    </ol>
    <pre><code class="language-shell">git clone https://gitee.com/laravel-admin/laraveladmin.git
cd laraveladmin
</code></pre>
    <ol start="2">
        <li>参照.env.example配置.env文件(务必设置好mysql密码,redis密码)</li>
    </ol>
    <ul>
        <li>数据库连接用户请使用root,程序需要检查数据库是否存在并创建数据库,开发环境的代码生成是通过读取数据表结构进行代码生成的</li>
    </ul>
    <pre><code class="language-shell">cp .env.example .env
vi .env
</code></pre>
    <ol start="3">
        <li>初始化安装</li>
    </ol>
    <pre><code class="language-shell">sh ./docker/install.sh
</code></pre>
    <ol start="4">
        <li>
            <p>设置当前代码目录的上级目录跟&quot;~&quot;目录必须包含 dokcer的File Sharing列表中的目录中</p>
        </li>
        <li>
            <p>php容器环境中安装composer相关扩展包及项目代码初始化</p>
        </li>
    </ol>
    <blockquote>
        <p>如果安装&quot;laravel/envoy&quot;过程中失败请切换下全局镜像源,进行尝试</p>
    </blockquote>
    <pre><code>- 腾讯云composer镜像源:https://mirrors.cloud.tencent.com/composer
- 阿里云composer镜像源:https://mirrors.aliyun.com/composer
- 华为云composer镜像源:https://mirrors.huaweicloud.com/repository/php
- laravel(中国)composer镜像源:https://packagist.laravel-china.org
- phpcomposer:https://packagist.phpcomposer.com
</code></pre>
    <pre><code class="language-shell">docker-compose run --rm php composer config -g repo.packagist composer https://mirrors.cloud.tencent.com/composer #设置镜像源
docker-compose run --rm php composer global require laravel/envoy -vvv #该命令出错了请切换镜像源
docker-compose run --rm php composer global dump-autoload
docker-compose run --rm node cnpm install #前端编译扩展包安装
docker-compose run --rm node npm run prod #编译前端页面js
docker-compose run --rm php envoy run init --branch=master #项目初始化
docker-compose up -d #启动服务
</code></pre>
    <ol start="6">
        <li>
            <p>系统已安装有nginx服务器导致端口(80,443)冲突依据如下进行配置</p>
            <ul>
                <li>将nginx容器暴露宿主机端口修改防止冲突</li>
            </ul>
        </li>
    </ol>
    <pre><code class="language-shell">vim docker-compose.yml
</code></pre>
    <p><img src="https://www.laraveladmin.cn/storage/uploads/images/2020/12/28/jYgF3xITF8KGmqgDHTNtqOP6fZeAySo11Bih2mkY.jpeg" alt="宿主机暴露端口修改" /></p>
    <pre><code>- 设置本机已有的nginx代理配置
</code></pre>
    <pre><code>server
{
    listen 80;
    server_name local.laraveladmin.cn;
    location / {
          proxy_http_version 1.1;
          proxy_set_header X-Real-IP $remote_addr;
          proxy_set_header X-Real-PORT $remote_port;
          proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
          proxy_set_header Host $http_host;
          proxy_set_header Scheme $scheme;
          proxy_set_header Server-Protocol $server_protocol;
          proxy_set_header Server-Name $server_name;
          proxy_set_header Server-Addr $server_addr;
          proxy_set_header Server-Port $server_port;
          proxy_pass http://host.docker.internal:81;
    }
}
</code></pre>
    <ol start="7">
        <li>
            <p><a href="/aliyun_sms.md" title="解决扩展包mrgoon/aliyun-sms自动加载问题">解决扩展包mrgoon/aliyun-sms自动加载问题</a></p>
        </li>
        <li>
            <p>访问</p>
        </li>
    </ol>
    <p>本地开发环境绑定hosts后就可以进行访问了</p>
    <pre><code>127.0.0.1 local.laraveladmin.cn
</code></pre>
    <ol start="9">
        <li>开发环境前端实时编译启动</li>
    </ol>
    <pre><code class="language-shell">docker-compose run --rm node npm run watch
</code></pre>
    <ol start="10">
        <li>代码更新升级</li>
    </ol>
    <pre><code class="language-shell">docker-compose exec php envoy run update --branch=master
</code></pre>
    <h4>使用说明</h4>
    <ol>
        <li>
            <p><a href="https://www.laraveladmin.cn">官网及相关文档: https://www.laraveladmin.cn</a></p>
        </li>
        <li>
            <p><a href="https://demo.laraveladmin.cn">在线示例演示环境: https://demo.laraveladmin.cn</a></p>
        </li>
    </ol>
    <p>用户名:demo_admin</p>
    <p>密码:admin123456</p>
    <h4>参与贡献</h4>
    <ol>
        <li>Fork 本仓库</li>
        <li>新建 Feat_xxx 分支</li>
        <li>提交代码</li>
        <li>新建 Pull Request</li>
    </ol>

</div>
<div id="app" class="app">
    <transition name="fade" enter-active-class="animated zoomIn faster" mode="out-in" leave-active-class="animated zoomOut faster">
        <router-view></router-view>
    </transition>
</div>
<script src="{{ mix('/js/bootstrap.js') }}" type="application/javascript"></script>
<script src="{{ mix('/js/app.js') }}?{{$time_str}}" type="application/javascript"></script>
</body>
</html>

