# laravelAdmin

[![Packagist](https://img.shields.io/packagist/l/encore/laravel-admin.svg?maxAge=2592000)](https://gitee.com/laravel-admin/laraveladmin)  
[![Total Downloads](https://img.shields.io/packagist/dt/zsping1989/laravel-admin.svg?style=flat-square)](https://gitee.com/laravel-admin/laraveladmin)  
[![Awesome Laravel](https://img.shields.io/badge/Awesome-Laravel-brightgreen.svg)](https://gitee.com/laravel-admin/laraveladmin)

#### 介绍
`laravel-admin`是一个可以快速帮你构建后台管理的工具，它提供的页面组件和表单元素等功能，能帮助你使用很少的代码就实现功能完善的后台管理功能。\(QQ群: 391528810\)
[Demo](http://www.laraveladmin.cn) \|\| [阅读文档](http://www.laraveladmin.cn/home/index)


## Screenshots

![laravel-admin](http://help.laraveladmin.cn/assets/F959191C-187F-4ADA-B0BD-428F81639A24.png)

#### 软件架构

基于laravel框架实现前后端分离的单页面应用架构

使用相关技术:vue+bootstrap+phpswoole+docker+laravel


#### 安装前准备

1. 提前安装好git

2. Windows安装请先手动安装好docker,并执行命令docker-compose -v检查docker是否已安装成功

3. Windows环境请进入git bash命令行工具进行执行安装

#### 安装教程

1. 下载代码

```shell script
git clone https://gitee.com/laravel-admin/laraveladmin.git
cd laraveladmin
```

2. 参照.env.example配置.env文件(务必设置好mysql密码,redis密码)

```shell script
cp .env.example .env
vi .env
```

3. 初始化安装

```shell script
sh ./docker/install.sh
```

4. 设置当前代码目录的上级目录跟"\~"目录必须包含 dokcer的File Sharing列表中的目录中(Windows环境的"\~"目录为"C:/Users/Administrator")

5. php容器环境中安装composer相关扩展包及项目代码初始化

```shell script
docker-compose run --rm php composer config -g repo.packagist composer https://mirrors.cloud.tencent.com/composer && \
docker-compose run --rm php composer global require laravel/envoy -vvv && \
docker-compose run --rm php composer global dump-autoload && \
docker-compose run --rm node cnpm install && \
docker-compose run --rm node npm run prod && \
docker-compose run --rm php envoy run init --branch=master && \
docker-compose up -d
```

6. [解决扩展包mrgoon/aliyun-sms自动加载问题](/aliyun_sms.md "解决扩展包mrgoon/aliyun-sms自动加载问题")

7. 访问

本地开发环境绑定hosts后就可以进行访问了

```
127.0.0.1 local.laraveladmin.cn
```

8. 代码更新升级

```shell script
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

