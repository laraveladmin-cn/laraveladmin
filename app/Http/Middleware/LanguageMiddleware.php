<?php

namespace App\Http\Middleware;

use Closure;
use EasyWeChat\Kernel\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class LanguageMiddleware{

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
        $key = 'Language';
        $default = config('app.locale');
        $language = $request->header($key,$request->cookie($key))?:$this->preferredLanguage($request);
        $language = $language?:$default;
        app('translator')->setLocale(
            str_replace('-','_',$language)
            //$language
        );
        $response = $next($request);
        //后置操作
        return $response;
    }

    /**
     * 客户端期望语言
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function getAcceptLanguage(Request $request){
        return collect(explode(',',$request->header('Accept-Language','')))->map(function ($value){
            return Arr::get(explode(';',$value),'0');
        });
    }

    /**
     * 首选语言
     */
    public function preferredLanguage(Request $request){
        return $this->getAcceptLanguage($request)->first(function ($language){
            return in_array($language,config('laravel_admin.locales'));
        });
    }
}
