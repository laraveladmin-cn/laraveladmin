<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class DecodeDataMiddleware
{

    /**
     * 服务端私钥
     * @var string
     */
    protected $server_rsa='';

    protected $except = [
        '/web-api/home/upload/index',//文件上传
        '/api/home/upload/index',
    ]; //排除路由



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
        $api_encryption = (config('laravel_admin.api_encryption')?:0)-0; //0-不需要加密,1-兼容加密,2-强制加密传输
        $method = $request->method();
        if(
            !in_array($method,['get','GET']) && //非get请求
            (($api_encryption==2 && !$this->inExceptArray($request)) || //强制加密传输
            $request->header('Api-Encryption')==1) //客户端加密传输
        ){
            $payload = collect($request->all())->except(collect($request->query())->keys()->toArray())->toArray();
            $data = $this->decryptData($payload,$this->server_rsa);
            if($data){
                collect(['aes_key','data','sign'])->each(function ($key)use($request){
                    $request->offsetUnset($key);
                });
                $request->merge($data);
            }
        }
        $response = $next($request);
        return $response;
    }

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
     * 解密传入数据
     * @return void
     */
    public function decryptData($raw_data,$pri_key){
        if(!$raw_data){
            throw ValidationException::withMessages([
                'aes_key'=>['解密KEY必填'],
                'data'=>['提交数据值必填'],
                'sign'=>['签名值必填'],
            ]);
        }
        $sign = Arr::get($raw_data,'sign');
        $data = Arr::get($raw_data,'data');
        $aes_key = Arr::get($raw_data,'aes_key');
        $error = [];
        if(!$aes_key){
            $error['aes_key'] = ['解密KEY必填'];
        }
        if(!$data){
            $error['data'] = ['提交数据值必填'];
        }
        if(!$sign){
            $error['sign'] = ['签名值必填'];
        }
        if(!$sign || !$data || !$aes_key){
            throw ValidationException::withMessages($error);
        }
        $key = md5(config('app.key')); // 密钥
        $sign_data_str = collect($raw_data)
                ->except(['sign'])
                ->toJson(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).$key;
        $sign_md5_str = md5($sign_data_str);
        if($sign!==$sign_md5_str){
            throw ValidationException::withMessages([
                'sign'=>['签名值验证失败'],
            ]);
        }
        $aes_key_raw = base64_decode($aes_key);
        $iv = '';
        openssl_private_decrypt($aes_key_raw, $iv, $pri_key);
        //dd($iv_decrypted_data);
        $cipher = "AES-256-CBC"; // 加密算法
        //dd(base64_decode($data), $cipher, $key, OPENSSL_RAW_DATA, $iv);
        $res = openssl_decrypt(base64_decode($data), $cipher, $key, OPENSSL_RAW_DATA, $iv);// 加密
        return json_decode($res,true)?:[];
    }
}
