<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Open\LoginController;
use App\Services\SessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Closure;
use Illuminate\Support\Facades\Response;

class AuthenticateRedirect{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $user = Auth::user();
        $force_logout = false; //是否强制退出
        if( !$user || //没有登录
            $force_logout = (config('laravel_admin.sso') && //单点登录强制退出
            $user->client_id &&
            $user->client_id!=SessionService::getId())
        ){
            $url = '/open/login';
            $referer_page = FacadesRequest::instance()->header('RefererPage','');
            if($referer_page){
                $url .='?back_url='.$this->getRequestUri($referer_page);
            }
            return Response::returns([
                'title'=>Lang::get('status.status302'),
                'content'=>Lang::get('status.redirectTo').$url,
                'redirect' => $url,
                'force_logout'=>$force_logout
            ],302);
        }
        return $next($request);
    }

    public function getRequestUri($url){
        $info = parse_url($url);
        $str = '';
        if($path = Arr::get($info,'path')){
            $str .= $path;
        }
        if($query = Arr::get($info,'query')){
            $str .= '?'.$query;
        }
        if($fragment = Arr::get($info,'fragment')){
            $str .= '#'.$fragment;
        }
        return $str;
    }
}
