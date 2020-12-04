<?php


namespace App\Services;
use \App\Facades\ClientAuth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class SessionService
{
    /**
     * api存值生命周期
     * @var float|int
     */
    static $api_lifetime = 3600*24*2;
    /**
     * 存值
     */
    static public function put($key, $value = null){
        if(ClientAuth::isApi()){
            if(is_array($value)){
                $value = json_encode($value);
            }
            return Cache::set(ClientAuth::id().':'.$key,$value,self::$api_lifetime);
        }else{
            return session()->put($key,$value);
        }
    }

    /**
     * 取值
     */
    static public function get($key, $default = null){
        if(ClientAuth::isApi()){
            $value = Cache::get(ClientAuth::id().':'.$key,$default);
            if($value && is_string($value) && Str::is('{*}',$value)){
                return json_decode($value,true);
            }
            return $value;
        }else{
            return session()->get($key,$default);
        }
    }

    /**
     * 删除
     * @param $key
     * @return bool|void
     */
    static public function forget($key){
        if(ClientAuth::isApi()){
            return Cache::forget(ClientAuth::id().':'.$key);
        }else{
            return session()->forget($key);
        }
    }

}
