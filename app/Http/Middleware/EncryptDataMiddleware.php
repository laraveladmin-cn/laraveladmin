<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class EncryptDataMiddleware
{
    /**
     * 客户端公钥
     * @var string
     */
    protected $client_rsa_pub='';

    protected $except = []; //排除路由

    public function __construct()
    {
        $disk = Storage::disk('root');
        $client_rsa_pub_file = 'storage/app/secret_key/api/client_rsa.pub';
        if($disk->exists($client_rsa_pub_file)){
            $this->client_rsa_pub = $disk->get($client_rsa_pub_file);
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
        $api_encryption = (config('laravel_admin.api_encryption')?:0)-0; //0-不需要加密,1-兼容加密,2-强制加密传输
        if(
            get_class($response)=='Illuminate\Http\JsonResponse' && //响应是json数据
            (($api_encryption==2 && !$this->inExceptArray($request)) || //强制响应加密
                $request->header('Support-Response-Encryption')==1 || //客户端支持响应加密
                $request->get('response_encryption')==1
            )
        ){
            $content = json_decode($response->getContent(),true);
            $encrypt_content = $this->encryptData($content,$this->client_rsa_pub);
            $response->setContent(json_encode($encrypt_content));
            $response->header('Response-Encryption',1);
        }
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
     * 加密响应数据
     * @return void
     */
    public function encryptData($raw_data,$pub_key){
        $key = md5(config('app.key')); // 密钥
        $cipher = "AES-256-CBC"; // 加密算法
        $iv_random = random_bytes(openssl_cipher_iv_length($cipher)); // 初始化向量（IV）
        $iv_base64 = base64_encode($iv_random);
        $iv = substr(md5($iv_base64),0,16);//16位数向量值
        //$iv = '025c8c1a9065b789';
        $data = base64_encode(openssl_encrypt(json_encode($raw_data), $cipher, $key, OPENSSL_RAW_DATA, $iv));// 加密
        //dd($data_str,$key,$data,$iv);
        $aes_key_raw = '';
        openssl_public_encrypt($iv, $aes_key_raw, $pub_key);
        $aes_key = base64_encode($aes_key_raw);
        $res = [
            'aes_key'=> $aes_key,//公钥加密后的值
            'data'=>$data, //对称加密后的值
        ];
        //dump(json_encode($res).$key);
        $res['sign'] = md5(json_encode($res,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).$key);
        return $res;
    }

}
