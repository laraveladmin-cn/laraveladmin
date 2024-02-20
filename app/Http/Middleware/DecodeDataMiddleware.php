<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class DecodeDataMiddleware
{

    /**
     * 服务端私钥
     * @var string
     */
    protected $server_rsa='';

    public function __construct()
    {
        $disk = Storage::disk('root');
        $server_rsa_file = 'storage/app/secret_key/api/server_rsa';
        if($disk->exists($server_rsa_file)){
            $this->server_rsa = $disk->get($server_rsa_file);
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        return $response;
    }


    /**
     * 解密传入数据
     * @return void
     */
    public function decryptData($data_str,$pri_key){
        if(!$data_str){
            return false;
        }
        $raw_data = json_decode($data_str,true);
        if($raw_data===false){
            return false;
        }
        $sign = Arr::get($raw_data,'sign');
        $data = Arr::get($raw_data,'data');
        $aes_key = Arr::get($raw_data,'aes_key');
        if(!$sign || !$data || !$aes_key){
            return false;
        }
        $key = md5(config('app.key')); // 密钥
        if($sign!==md5(collect($raw_data)->except(['sign'])->toJson(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).$key)){
            return false;
        }
        $aes_key_raw = base64_decode($aes_key);
        $iv = '';
        openssl_private_decrypt($aes_key_raw, $iv, $pri_key);
        //dd($iv_decrypted_data);
        $cipher = "AES-256-CBC"; // 加密算法
        //dd(base64_decode($data), $cipher, $key, OPENSSL_RAW_DATA, $iv);
        return openssl_decrypt(base64_decode($data), $cipher, $key, OPENSSL_RAW_DATA, $iv);// 加密
    }
}
