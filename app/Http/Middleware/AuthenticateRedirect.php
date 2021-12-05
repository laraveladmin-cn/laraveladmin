<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Closure;
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
        if(!Auth::user()){
            $url = '/open/login';
            $referer_page = \Illuminate\Support\Facades\Request::instance()->header('RefererPage','');
            if($referer_page){
                $url .='?'.http_build_query(['back_url'=>$this->getRequestUri($referer_page)]);
            }
            return orRedirect($url,302);
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
