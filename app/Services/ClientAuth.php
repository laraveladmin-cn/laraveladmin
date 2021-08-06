<?php
/**
 * Created by PhpStorm.
 * User: zhangshiping
 * Date: 2019-02-22
 * Time: 10:31
 */

namespace App\Services;


use App\Facades\LifeData;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class ClientAuth
{
    protected $routePrefix='';
    protected $key='';

    public function __construct()
    {
        $this->routePrefix = getRoutePrefix();
        $this->key = config('laravel_admin.client_id_key');
    }

    /**
     * 创建一个客户端
     * @param bool $force
     * @return array|string|null
     */
    public function getClient($force=false){
        $key = $this->key;
        $client_id = Request::header($key,Request::cookie($key,''));
        if(!$force && $client_id){
            return $client_id;
        }
        $token = [
            'id'=>md5(microtime().rand(0,100000)),
            'time'=>time()
        ];
        return Crypt::encryptString(json_encode($token));
    }

    /**
     * 认证客户端
     * @return array
     */
    public function auth(){
        return LifeData::remember('_client_auth_decoded',function (){
            $key = $this->key;
            $token = urldecode(Request::header($key,Request::cookie($key,'')))?:'';
            try{
                $decoded = collect(json_decode(Crypt::decryptString($token),true))->toArray();
            }catch (\Exception $e){
                $decoded = [];
            }
            return $decoded;
        });
    }

    public function id(){
        return LifeData::get('_client_auth_decoded.id','');
    }

    /**
     * 判断是否是访问的API路由
     * @return mixed
     */
    public function isApi(){
        return LifeData::remember('_is_api',function (){
            if(!Request::route()){
                return false;
            }
            return Str::startsWith('/'.Request::route()->getPrefix(),$this->routePrefix);
        });
    }

}
