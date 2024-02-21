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

    public function test(){
        $pri_key = <<<str
-----BEGIN PRIVATE KEY-----
MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQC+trbYwuTsgj91
YYCfBddegYYtiLIID4BTzwR1DPxDdk2qQBs2zBuwj1BcFiyUJ6LMTj0DTtGlRxui
wMLwUxz18asqAMsG1TSTqcOnKzq9tX9vMi5gBtwJfiAnrtd8fQQRW3/AJnbDfGKc
BHspp5SfBubLVwqrqiKbaaDoHmsTKht6lSB577Qo8D9/F0JMPZh+x1QejhmM9Cu5
XfneDlo5/WjFKq6pe93MNeGNZFPAP66zuzMwBGhd0TdTivf1ay32T421KE74Xiac
YLF6z/kKRKz86iGNbDeCxyOXpn09GBulc5Oh0Ow6ER519sTQrQCk+SsNBSulqfpt
5uNoe8QdAgMBAAECggEATnT6Wcgrx0R5+L8o28LabA2a9oaCvyApadEDg2fZK6Oy
pbSDvZJQXd1HcOrKYhTAO46AOSkmw/ix3M2yJI38nw1RnhD/dQsm+wxe6hm1q6/M
AiHBxE1uHhWeAtVB3vvLPZzHvHPWbetw4cBSLru7P4TmU4a2ZBK08/yLbpJ8+D+m
3lqw5Vn0ZAqS+cMvA6K6Y9nKed9byT0RTCjSzjeBj5arrJSkSzucXmshnYeEn5Ij
R8t/zfpjQEcFqo8wQU4XBqXKVQ+O4ZxrvrI1JmJaMsW8+RyO4E2qOn1r3kzfNy9v
pqJXHnNcaGev+bF9olCYGZUGXvcBjn3Jjp7yhI3h4QKBgQDw1shp7Nsy/8YQZx4v
Ukoco7dGhBIt69b5IzcLpxrK/rBQDF8FH3I1BUFqM1uOi4UU/QCG2+eDjihF/0hl
fCN0t4MAv1FoNF2tUWdyv5fuAAng4Wb8OEmzlXVya0w/JM+4QrUce77Py0y2NSjJ
ZPpgNNmyEJ2RGssKhqZwyh7pxQKBgQDKuCR+akM7m8gZMcxh4heVlQsczvcwuGDw
1IPvsg29Z+hLBmgC6MDTTk3h1YSdX25a/Tk/eJngfArqJ51xZbURMTttHWXB2MFn
QDm6d5Rx4ZmvahbpAsmPLWfP/09Ml+4UuhJIKLJElKIWhj0So2dm3e8HTz8on7Wk
XXssmKSOeQKBgFL7XmCI+NnwoRkDvrXFX73QdxS36t+htBdxl8TPFf89lBhwusi0
FhDIt8pU2cYasocRyX2uBW4hrCS6GgLFrB3KITw/r1f9Ow29z6wM8ddSchTm9SoQ
ZuyWoboD2GilUWEGswqWZJ+KR+s8E8qYnWBKtXuSGAhoN+9vh6ezLMWVAoGAO+TK
C3uT37G4HhGDhEwLkctWXC2eBQwEwELZtGEUBCkGDdyXsHxaNFRHWHkAVIrUjReR
6XnVZOjhRKttrgpRxAGawDNWVD6ZbcshA0G/XyI7iQM8P53uNVpB+MdDA6tD0WXk
buNvQCn19de1haM3ssHRlIRKcdM2FJj2Aoga3mkCgYEA1do5F25sCVR5TQw9ERfr
rwfZtVVedqnUnGbI5V7INXaAiyOJHBKv10sSOEwPwLho7SEIgKr0/XC/AtjOqPGy
uJlYHWjHjC+Xy4r+HnipupqbjJitbVQYUh5TsmLsXkmcEzKtA0gqoy0522e81TRW
K/9s/piafMBPUhj62OENta0=
-----END PRIVATE KEY-----
str;
        $pub_key = <<<str
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvra22MLk7II/dWGAnwXX
XoGGLYiyCA+AU88EdQz8Q3ZNqkAbNswbsI9QXBYslCeizE49A07RpUcbosDC8FMc
9fGrKgDLBtU0k6nDpys6vbV/bzIuYAbcCX4gJ67XfH0EEVt/wCZ2w3xinAR7KaeU
nwbmy1cKq6oim2mg6B5rEyobepUgee+0KPA/fxdCTD2YfsdUHo4ZjPQruV353g5a
Of1oxSquqXvdzDXhjWRTwD+us7szMARoXdE3U4r39Wst9k+NtShO+F4mnGCxes/5
CkSs/OohjWw3gscjl6Z9PRgbpXOTodDsOhEedfbE0K0ApPkrDQUrpan6bebjaHvE
HQIDAQAB
-----END PUBLIC KEY-----
str;
        $str = $this->encryptData('123',$pub_key);
        dd($str,$this->decryptData($str,$pri_key));




        $encryptedData = <<<'str'
doLWtSknV/6eHneJYkxGbq7oieuNMHtokqIwvQni/cyHtTuGD4wBWOEMjXsfu5sB2E1zhfrlXRHe2naFxTAmNmkH/lXZe37wkFjOcO7NClkmglh2PtJYnnoXkBINpfZpOeFtf+7IstPl/rCpmmZ8ZqSfdVXoWE9deA/6Vhp/mTw46N8A/Ai3lo/acYB4a1uVjRsF8CEry7+mSKjiylVC/UlBWB7U1uLL85AiCoMeJ9DBlj8TmjtRAmI4xa4nE+blJV5vpJ+sEOwAOOabscMACbO5lugYWfZo8Pr7EvDWYqn3n/sYEstskVjzO/V0QcdrIayMZWHfJjRSHlrBJnV8Xw==
str;
        $privateKey = <<<str
-----BEGIN PRIVATE KEY-----
MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC7gB5FvxOHLsa6
0nY22mbpkbLMOCONJHjVAUEI9qg875RLHMKchCMN/qhq96Yu5Hk+8k2DtVD+B5mr
gMkTU6HJXGRvS21ZbxFHTj7bU5LWtChxB9DglclTTvvrT/g98r7XPXIdpIYjR0m7
fVl+PCcfOp873UsFQki1kjgY/mRNT+nlDRjmonaPHziWF6i0vjxPjvm9OJLVTmbl
paSFk1/vqUTu0zFFtnR5U48JYZFIchyL8wum+e2vV7B6ksXaGVl0UAIcNEBu0SKy
TtnSdB0Ii6F9iF9XCyMJeiNVXbCRO22D71BnCwyjGp5hM8ZXvp66Awng8V58sCV6
lc0FQhWJAgMBAAECggEAPsF34GI+t/04+KiedmeNEFn6nQ2hIIl3g9uCl+xujM6n
NKiwnlA/p1x3pC21Snaf+iiBNzcFn7CNh3B4XGaefNXWq8V0GP3qq5INybzkJcZw
zrwN9k1L7/08phrC/ID1zPa87hz15HLkw8MFpBGgCnzFdPTxOhZgXZ1N91eV3KXy
f0ylYeq8Hho7ji8PxzBRfmSX/g54uSVMAe005i4g1fzD/GWyXmkHpYityfA584kn
x+u3p8NLOPv7O+t04hRT0bWhR41fHR2o8D974x3YhPbqXNn0kM6AC1XG1f5oC4XQ
Avjv/AxWKiWVCOjqR1upa14ncPXSm9lLas23Jq7ofQKBgQDtodWhpHo22yzsntDS
RKvsuIcdTfjhZ8OBjKfi9EdZT3u+qlkJe5+fWyCQbDeaJRI2E0hTuGBv5CZQUWTg
8EncDuRhsiw/co9gIb0EBpxrLfx7GMzfcjPqzK9YoGLj6LQBn1YnAxMnZcYb/p0K
sovJpzs67Y1U+3tyxfxNSxTzmwKBgQDJ/kx0KLme2HXgurWhIlS1xYa99FN3T8Ih
2L/eHyHn1i7405y0MD1Mhwjb68RTRUb0u3QLpy+vBKJnvIQBBaqWefSzaYWWBy71
KK67BysoPrmX0ECQ0cUPw9BzP5FyPr8A4q9TOwvujBl/2MewovJgeDeAKNcU6TS0
5gAw9MBnqwKBgQC4ZInHAkArbOtxONNFNjBKYe3GWYi0L7ZPQnvL6k2rCbg1/S1V
5G26VBXyu2Zx4C4/c7r96+Y5LMpmLKKgwRQvBAdHn+Ah451JtSRciVy69lYilt3y
zUVn/yhZFytlOl7jm2ZYo1QrkBeoBWyKrn02HuQhF9BBj1r9dpAO0iIR3QKBgDfp
sYYR49fJeU+8vxwcYbBzPeoE4LnNFSLDWdEFcyA2lIgCI4VpOP6e/l/J8m1OZubF
oMi8/aEHumDWuP+DbwX6OjcThYvS7zejjEJvKI4aVstkNQshVdgYTvIn7X3fSoXX
OcrjNFlS5JgUDKqjYE492LccFvVN3G4aoIDsrvnDAoGBAMRNR0wEtpWckWUnNSO4
Mo4MLJMQkwI5iwrcEpCWJ5gnGjpg4yHyYqJ3nbF3yIs/q88dS+IJXz6V8leVU0cc
7sZXyikoRe+WqA8Hc5ooziDpXM97zxjQzRUsJghs7Ooy0Kk40s5GEOpTU6nFqSUe
q1xq0dxfyjkOFBfO9e1yUo5f
-----END PRIVATE KEY-----
str;
        $decryptedData = '';

        openssl_private_decrypt(base64_decode($encryptedData), $decryptedData, $privateKey);
        dd($decryptedData);
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
