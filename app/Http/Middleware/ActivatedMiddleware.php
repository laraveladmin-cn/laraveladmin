<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class ActivatedMiddleware{
    /**
     * 脚本运行时调用
     *
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if(User::where('id',$user['id'])->value('status')==0){
            dd(trans('Please activate it through the user\'s registered email!'));
        }
        $response = $next($request);
        //后置操作
        return $response;
    }


    /**
     *
     * 结果返回到客户端后调用
     *
     * Handle an incoming request.
     *
     * param  \Illuminate\Http\Request  $request
     * param  \Closure  $next
     * return mixed
     */
    public function terminate($request, $response)
    {



    }
}
