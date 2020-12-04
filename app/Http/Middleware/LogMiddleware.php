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

class LogMiddleware{

    protected $log_id_key='_log_id';

    protected $hidden = ['password','password_confirmation'];


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
        $route = Route::getCurrentRoute()->uri;
        //请求方式
        $method = strtolower(app('request')->method());
        if(!in_array(strtolower($method),config('laravel_admin.log_exclude_method',[]))){
            $ip = RequestFacade::header('x-real-ip',RequestFacade::ip());
            $parameters = RequestFacade::all();
            collect($this->hidden)->map(function ($value)use(&$parameters){
                if(isset($parameters[$value])){
                    $parameters[$value] = preg_replace("/./","*",$parameters[$value]);
                }
            });
            $log = Log::create([
                'menu_id'=>Arr::get(Menu::hasPermission($route,$method,false),'id',0),
                'user_id'=>User::getOperateId(),
                'location'=>collect(Ip::find($ip))->take(4)->filter()->unique()->implode(','),
                'ip'=>$ip,
                'parameters'=>json_encode($parameters,JSON_UNESCAPED_UNICODE),
                'return'=>''
            ]);
            LifeData::set($this->log_id_key,$log['id']);
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
        if($log_id = LifeData::get($this->log_id_key)){
            //写入返回数据
            $str = collect(LifeData::all())->filter(function ($item,$key){
                return !Str::is('_*',$key);
            })->toJson(JSON_UNESCAPED_UNICODE);
            Log::where('id',$log_id)->update(['return'=>$str,'user_id'=>User::getOperateId()]);
        }
    }
}
