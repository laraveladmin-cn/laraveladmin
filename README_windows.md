
<p align="center">
    <img src="https://www.laraveladmin.cn/dist/img/logo1.png" data-origin="httpw://www.laraveladmin.cn/dist/img/logo1.png" alt="Logo" style="width: 200px" />
</p>

<p align="center">
    <a href="https://gitee.com/laravel-admin/laraveladmin" target="_blank" rel="noopener">
        <img src="https://img.shields.io/packagist/l/encore/laravel-admin.svg?maxAge=2592000" data-origin="https://img.shields.io/packagist/l/encore/laravel-admin.svg?maxAge=2592000" alt="Packagist">
    </a>  
    <a href="https://gitee.com/laravel-admin/laraveladmin" target="_blank" rel="noopener">
        <img src="https://img.shields.io/packagist/dt/zsping1989/laravel-admin.svg?style=flat-square" data-origin="https://img.shields.io/packagist/dt/zsping1989/laravel-admin.svg?style=flat-square" alt="Total Downloads">
    </a>
    <a href="https://gitee.com/laravel-admin/laraveladmin" target="_blank" rel="noopener">
        <img src="https://img.shields.io/badge/Awesome-laraveladmin-green" data-origin="https://img.shields.io/badge/Awesome-laraveladmin-green" alt="Awesome Laravel">
    </a>
</p>

# LaravelAdmin

#### 介绍

`laravel-admin`是一个可以快速帮你构建后台管理的工具，它提供丰富的页面组件和表单元素，还有即插即用的功能组件，通过简单的配置或使用少量的代码就实现完善的后台管理功能。\(QQ群: 391528810\)

[Demo](http://demo.laraveladmin.cn) \|\| [阅读文档](http://www.laraveladmin.cn/home/index)

**QQ群: `391528810`**

![QQ群](https://www.laraveladmin.cn/api/home/docs/images/QQ群.jpg)

#### 特点

- Laravel+Vue组合
- SPA单页面应用
- 前后端分离,后台只提供API接口,前端负责视图渲染
- 开箱即用的laravel后台管理系统
- 海量Vue组件直接拿来即用

## 截图

![laravel-admin](https://www.laraveladmin.cn/storage/uploads/images/2020/12/05/kg3F2blsJISs6GbyFdmItHU7VKGLPx4zUIrPS0H6.jpeg)

#### 软件架构

基于laravel框架实现前后端分离的单页面应用架构

使用相关技术:vue+bootstrap+phpswoole+docker+laravel

### Mac环境,Linux环境安装请查看 [Linux安装](README.md)
### 已有项目环境手动安装请查看 [手动安装](README_self.md)

#### 安装前准备

1. 提前安装好git(整套部署流程使用git方式部署,请依照文档通过git clone命令安装)

2. Windows安装请先手动安装好docker(电脑需支持Hyper-V),并执行命令docker-compose -v检查docker是否已安装成功

3. Windows注意要进入容器请在命令前加上"winpty "

4. Windows请手动设置下载源为国内镜像源

```json5
{
    "registry-mirrors" : [
        "https://mirror.ccs.tencentyun.com",
        "http://registry.docker-cn.com",
        "http://docker.mirrors.ustc.edu.cn",
        "http://hub-mirror.c.163.com"
    ],
    "insecure-registries" : [
        "registry.docker-cn.com",
        "docker.mirrors.ustc.edu.cn"
    ],
    "debug" : true,
    "experimental" : true
}

```

![docker国内镜像设置](https://www.laraveladmin.cn/storage/uploads/images/2020/12/08/7x7wz5WhsQw9drW7yXFmN7DLjZGWvzubcO4PKzFi.png)

5. Windows的其它设置参照

![Windows Docker设置1](https://www.laraveladmin.cn/storage/uploads/images/2020/12/09/P4zc6g4g8pG7DkZjfuC0w6tGDq6eKfJ9mMrumxIR.png)
![Windows Docker设置2](https://www.laraveladmin.cn/storage/uploads/images/2020/12/09/ZOZaJgLBtWQPmSgHClTixeKinFcFP4Da0CTsA2ia.png)
![Windows Docker设置3](https://www.laraveladmin.cn/storage/uploads/images/2020/12/09/SHCVxkHIf6eaLft4yaT1ztTyMXQ6Z8S4xFkx4g3R.png)

6. 设置预将代码存放目录的上级目录跟"\~"目录必须包含 dokcer的File Sharing列表中的目录中(Windows环境的"\~"目录为"C:/Users/Administrator")

> 我的Windows电脑只有一个C盘,直接选的C盘

![docker共享盘设置](https://www.laraveladmin.cn/storage/uploads/images/2020/12/08/kqeBi3cAq0D6NQD0H1mcLNdY3e6IqPUbUEJZwAZf.png)

7. 上面内容设置到docker设置中后记得点应用

8. Windows环境请进入git bash命令行工具进行执行安装
   
![进入git bash](https://www.laraveladmin.cn/storage/uploads/images/2020/12/09/DCVTN13VC08tcVTBGtpYB0xzCrhMf1Gq9DNKfEPl.png)

#### 安装教程

1. 下载代码

```shell
git clone https://gitee.com/laravel-admin/laraveladmin.git
cd laraveladmin
git remote add laraveladmin https://gitee.com/laravel-admin/laraveladmin.git
```

2. 参照.env.example配置[.env](env.md)文件(务必设置好mysql密码,redis密码)

- 数据库连接用户请使用root,程序需要检查数据库是否存在并创建数据库,开发环境的代码生成是通过读取数据表结构进行代码生成的

```shell
cp .env.example .env
vi .env
```

3. 初始化安装

```shell
sh ./docker/install.sh
```

4. 请用phpstorm编辑器查看./docker/mysql/init.sql密码值是否存在换行问题,如有请处理一下,不然后面数据库连接不上

5. php容器环境中安装composer相关扩展包及项目代码初始化

> 如果安装"laravel/envoy"过程中失败请切换下全局镜像源,进行尝试

    - 腾讯云composer镜像源:https://mirrors.cloud.tencent.com/composer
    - 阿里云composer镜像源:https://mirrors.aliyun.com/composer
    - 华为云composer镜像源:https://mirrors.huaweicloud.com/repository/php
    - laravel(中国)composer镜像源:https://packagist.laravel-china.org
    - phpcomposer:https://packagist.phpcomposer.com

```shell
winpty docker-compose run --rm php composer config -g repo.packagist composer https://mirrors.cloud.tencent.com/composer #设置镜像源
winpty docker-compose run --rm php composer global require laravel/envoy -vvv #该命令出错了请切换镜像源
winpty docker-compose run --rm php composer global dump-autoload
winpty docker-compose run --rm node cnpm install #前端编译扩展包安装
winpty docker-compose run --rm node npm run prod #编译前端页面js
winpty docker-compose run --rm php chmod u+x docker/php/run.sh #启动命令添加执行权限
winpty docker-compose run --rm php envoy run init --branch=master #项目初始化
winpty docker-compose up -d #启动服务
```

> 执行命令winpty docker-compose ps显示php容器一直restart的状态是部分Windows docker对"docker/php/run.sh"的文件编码不能识别问题!请执行如下操作
```shell
winpty docker-compose down
winpty docker-compose run --rm php bash
mv docker/php/run.sh docker/php/run.sh.back
echo '' > docker/php/run.sh
cat docker/php/run.sh.back >> docker/php/run.sh
chmod u+x docker/php/run.sh
chmod 777 docker/php/run.sh
exit
winpty docker-compose up -d
winpty docker-compose ps
```

> 安装完成请在编辑器排除这两个目录防止编辑器被卡死

![防止编辑器卡死](https://www.laraveladmin.cn/api/home/docs/images/防止编辑器卡顿.png)

6. 系统已安装有nginx服务器导致端口(80,443)冲突依据如下进行配置
    
    - 将nginx容器暴露宿主机端口修改防止冲突
    
```shell
vim docker-compose.yml
```
![宿主机暴露端口修改](https://www.laraveladmin.cn/storage/uploads/images/2020/12/28/jYgF3xITF8KGmqgDHTNtqOP6fZeAySo11Bih2mkY.jpeg)
    
    - 设置本机已有的nginx代理配置
    
```
server
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
          proxy_pass http://127.0.0.1:81; #docker容器中运行的nginx设置成http://host.docker.internal:81
    }
}
```

7. 访问

本地开发环境绑定hosts后就可以进行访问了

```
127.0.0.1 local.laraveladmin.cn
```

> 登录用户名及密码参照.env中的"ADMIN_USER_NAME","ADMIN_PASSWORD"设置项
> 登录验证码使用的极验滑块验证(免费的),注册后在.env中进行配置

8. 开发环境前端实时编译启动

```shell
winpty docker-compose run --rm node npm run watch
```

9. 添加自己的代码仓库源

```shell
git remote remove origin
git remote add origin https://用户名:密码@gitee.com/自己代码仓库.git
```

10. 本地开发环境更新到laraveladmin最新代码

```shell
git pull laraveladmin master
```

11. 线上代码更新升级部署

```shell
docker-compose exec php envoy run update --branch=master
```


#### 使用说明

1. [官网及相关文档: https://www.laraveladmin.cn](https://www.laraveladmin.cn)

2. [在线示例演示环境: https://demo.laraveladmin.cn](https://demo.laraveladmin.cn)

用户名:demo_admin
    
密码:admin123456

#### 参与贡献

1. Fork 本仓库
2. 新建 Feat_xxx 分支
3. 提交代码
4. 新建 Pull Request

