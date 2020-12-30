<?php

namespace App\Http\Middleware;

use App\Facades\ClientAuth;
use Closure;
use Illuminate\Support\Facades\Response;

class ClientMiddleware{

    public function __construct()
    {
        $this->except = [
            getRoutePrefix().'/open/config',
            getRoutePrefix().'/home/docs/*',
            getRoutePrefix().'/home/index'
        ];

    }

    protected $except = [];

    /**
     * Determine if the request has a URI that should pass through CSRF verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }

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
        if(!$this->inExceptArray($request)){
            $auth = ClientAuth::auth();
            if(!$auth){
                return Response::returns([
                    'message'=>'Unauthenticated.',
                    'type'=>'app_client'
                ],401);
            }
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
