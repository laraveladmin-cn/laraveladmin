<?php

namespace App\Http\Middleware;

use App\Facades\LifeData;
use App\Models\Log;
use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use \Illuminate\Support\Facades\Request as RequestFacade;
use Zhuzhichao\IpLocationZh\Ip;

class AdminMiddleware{

    /**
     * 脚本运行时调用
     *
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next, ...$guards)
    {
        //不是管理员,跳转到前台首页
        if(!User::isAdmin()){
            return orRedirect('/admin/403',403);
        }
        //当前路由
        //$route = Route::getCurrentRoute()->getCompiled()->getStaticPrefix();
        $route = Route::getCurrentRoute()->uri;
        //请求方式
        $method = strtolower(app('request')->method());
        //不是超级管理员,需要验证权限
        if(!Role::isSuper()){
            //判断当前路由是否在拥有权限url中
            $hasPermission = Menu::hasPermission($route,$method,false);
            //没有权限
            if(!$hasPermission){
                return orRedirect('/admin/403',403);
            }
        }
        $response = $next($request);
        //后置操作
        return $response;
    }
}
