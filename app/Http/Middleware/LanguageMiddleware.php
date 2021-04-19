<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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
        $language = $request->header($key,$request->cookie($key))?:collect(explode(',',$request->header('Accept-Language','')))
            ->first();
        $language = $language?:$default;
        if(!in_array($language,config('app.locales'))){
            $language = $default;
        }
        app('translator')->setLocale($language);
        $response = $next($request);
        //后置操作
        return $response;
    }
}
