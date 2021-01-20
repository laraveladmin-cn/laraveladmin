
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

### Mac环境,Linux环境安装请查看 [Linux安装](README.md)
### Windows环境安装请查看 [Windows安装](README_windows.md)

#### 安装环境要求

1. php>=7.4(目前项目使用的laravel8)

2. 已安装好mysql数据库

> 已有数据库请正确设置好数据库默认编码charset:utf8mb4;collation:utf8mb4_unicode_ci

3. 安装好nodejs,cnpm(用于前端模板打包编译)

> 安装cnpm

```shell
npm install -g cnpm --registry=https://registry.npm.taobao.org && \
cnpm -v
```

4. 安装好composer(用于下载php扩展包)

#### 安装前准备

1. 提前安装好git(整套部署流程使用git方式部署,请依照文档通过git clone命令安装)

2. Windows环境请进入git bash命令行工具进行执行安装
   
![进入git bash](https://www.laraveladmin.cn/storage/uploads/images/2020/12/09/DCVTN13VC08tcVTBGtpYB0xzCrhMf1Gq9DNKfEPl.png)

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

3. 安装composer相关扩展包及项目代码初始化(以下两种方式选一种进行安装即可)

> windows安装请先直接下载vendor.zip解压在项目代码中

[vendor.zip](https://www.laraveladmin.cn/api/home/docs/vendor.zip)

> phpstudy安装执行迁移命令出现如下错误时,可以升级mysql到8版本,或请参考解决方案[执行迁移文件错误解决](https://stackoverflow.com/questions/42244541/laravel-migration-error-syntax-error-or-access-violation-1071-specified-key-wa)
![执行迁移文件错误](https://www.laraveladmin.cn/api/home/docs/images/执行迁移文件错误.jpg)

3-1. 直接命令安装

```shell
cnpm install #前端编译扩展包安装
npm run prod #编译前端页面js
php artisan config:clear #清理配置缓存
php artisan cache:clear #清理缓存
php artisan key:generate --force #生成APP_KEY
php artisan storage:link #创建上传文件目录软连接
php artisan db:seed --class=CheckDatabaseSeeder --force #检查并创建数据库
php artisan migrate:all #创建数据表
php artisan db:seed --force #初始化数据
```

3-2. 通过envoy命令进行安装

> 如果安装"laravel/envoy"过程中失败请切换下全局镜像源,进行尝试

    - 腾讯云composer镜像源:https://mirrors.cloud.tencent.com/composer
    - 阿里云composer镜像源:https://mirrors.aliyun.com/composer
    - 华为云composer镜像源:https://mirrors.huaweicloud.com/repository/php
    - laravel(中国)composer镜像源:https://packagist.laravel-china.org
    - phpcomposer:https://packagist.phpcomposer.com

```shell
composer config -g repo.packagist composer https://mirrors.cloud.tencent.com/composer #设置镜像源
composer global require laravel/envoy -vvv #该命令出错了请切换镜像源
composer global dump-autoload
cnpm install #前端编译扩展包安装
npm run prod #编译前端页面js
envoy run init --branch=master --self=1 #项目初始化
```

> 安装完成请在编辑器排除这两个目录防止编辑器被卡死

![防止编辑器卡死](https://www.laraveladmin.cn/api/home/docs/images/防止编辑器卡顿.png)

4. 配置nginx访问请参照"docker/nginx/vhost_dev/local.laraveladmin.cn.conf"

5. 访问

本地开发环境绑定hosts后就可以进行访问了

```
127.0.0.1 local.laraveladmin.cn
```

> 登录用户名及密码参照.env中的"ADMIN_USER_NAME","ADMIN_PASSWORD"设置项
> 登录验证码使用的极验滑块验证(免费的),注册后在.env中进行配置

6. 开发环境前端实时编译启动

```shell
npm run watch
```

7. 代码更新升级

> Linux,Mac系统执行

```shell
envoy run update --branch=master --self=1
```

8. 添加自己的代码仓库源

```shell
git remote add self https://用户名:密码@gitee.com/自己代码仓库.git
```

9. 定时任务,队列,守护进程管理请自己手动添加

[定时任务](https://laravelacademy.org/post/8484)

[队列,Supervisor](https://laravelacademy.org/post/21535)

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

