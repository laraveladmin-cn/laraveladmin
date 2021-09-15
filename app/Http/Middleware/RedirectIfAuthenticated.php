<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
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
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) { //未登录访问
                $redirect = RouteServiceProvider::HOME;
                if(Arr::get(Auth::user(),'admin') ){
                    $hasPermission = Menu::hasPermission(RouteServiceProvider::ADMIN,'get',false);
                    if(!$hasPermission){
                        $url = Menu::mainAdmin()->where('is_page',1)->orderBy('left_margin','asc')->value('url');
                        if($url){
                            $redirect = $url;
                        }
                    }else{
                        $redirect =  RouteServiceProvider::ADMIN;
                    }
                }
                return orRedirect($redirect,302);
            }
        }

        return $next($request);
    }
}
