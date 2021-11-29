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
    <meta name="keywords" content="{{$app_name}},{{$app_name}}官网,{{$app_name}}单页面应用,{{$app_name}}前后端分离,Laravel后台管理系统,{{$app_name}}企业网站,{{$app_name}}要怎么用,{{$app_name}}文档,{{$app_name}}Swoole,Laravel,laravel-swoole,docker,官网:{{config('app.url')}}" />
    <meta name="description" content="{{$app_name}},简洁、直观、强悍的前端后端开发框架，让全栈开发更迅速的SPA单页面应用。企业官网:{{config('app.url')}}" />
    <link rel="icon" type="image/x-icon" href="{{config('laravel_admin.logo')}}">
    <link href="/css/adminlte.css?{{$time_str}}" rel="stylesheet">
    <link href="/css/app.css?{{$time_str}}" rel="stylesheet">
    {{--<link href="/css/tailwindcss.css?{{$time_str}}" rel="stylesheet">--}}
    <script src="{{config('app.url').getRoutePrefix(config('laravel_admin.web_api_model'))}}/open/config?script=AppConfig{{$time_str}}" type="application/javascript"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="app" class="app">
    <transition name="fade" enter-active-class="animated zoomIn faster" mode="out-in" leave-active-class="animated zoomOut faster">
        <router-view></router-view>
    </transition>
</div>
<script src="{{ mix('/js/bootstrap.js') }}" type="application/javascript"></script>
<script src="{{ mix('/js/app.js') }}?{{$time_str}}" type="application/javascript"></script>
</body>
</html>

