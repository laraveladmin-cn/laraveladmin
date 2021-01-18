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
`laravel-admin`是一个可以快速帮你构建后台管理的工具，它提供的页面组件和表单元素等功能，能帮助你使用很少的代码就实现功能完善的后台管理功能。\(QQ群: 391528810\)
[Demo](http://demo.laraveladmin.cn) \|\| [阅读文档](http://www.laraveladmin.cn/home/index)

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

### Windows环境安装请查看 [Windows安装](README_windows.md)
### 已有项目环境手动安装请查看 [手动安装](README_self.md)

#### 安装前准备

1. 提前安装好git(整套部署流程使用git方式部署,请依照文档通过git clone命令安装)

#### 安装教程

1. 下载代码

```shell
git clone https://gitee.com/laravel-admin/laraveladmin.git
cd laraveladmin
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

4. 设置当前代码目录的上级目录跟"\~"目录必须包含 dokcer的File Sharing列表中的目录中

5. php容器环境中安装composer相关扩展包及项目代码初始化


> 如果安装"laravel/envoy"过程中失败请切换下全局镜像源,进行尝试

    - 腾讯云composer镜像源:https://mirrors.cloud.tencent.com/composer
    - 阿里云composer镜像源:https://mirrors.aliyun.com/composer
    - 华为云composer镜像源:https://mirrors.huaweicloud.com/repository/php
    - laravel(中国)composer镜像源:https://packagist.laravel-china.org
    - phpcomposer:https://packagist.phpcomposer.com

```shell
docker-compose run --rm php composer config -g repo.packagist composer https://mirrors.cloud.tencent.com/composer #设置镜像源
docker-compose run --rm php composer global require laravel/envoy -vvv #该命令出错了请切换镜像源
docker-compose run --rm php composer global dump-autoload
docker-compose run --rm node cnpm install #前端编译扩展包安装
docker-compose run --rm node npm run prod #编译前端页面js
docker-compose run --rm php envoy run init --branch=master #项目初始化
docker-compose up -d #启动服务
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
docker-compose run --rm node npm run watch
```

9. 代码更新升级

```shell
docker-compose exec php envoy run update --branch=master
```

10. 添加自己的代码仓库源

```shell
git remote add self https://用户名:密码@gitee.com/自己代码仓库.git
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

