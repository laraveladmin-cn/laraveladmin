<?php
/**
 * 通过 PhpStorm 创建.
 * 创建人: zhangshiping
 * 日期: 16-5-3
 * 时间: 上午11:19
 *
 * 验证扩展类
 *
 */

namespace App\Validators;


use App\Facades\ClientAuth;
use App\Services\SessionService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Validator;
use ZBrettonYe\Geetest\Geetest;

class CustomValidator extends Validator{

    /**
     * 验证手机号码
     * 参数: $attribute
     * 参数: $value
     * 参数: $parameters
     * 返回: bool
     */
    public function validateMobilePhone($attribute, $value, $parameters)
    {
        if(!$value) return true;
        return preg_match("/^1[3456789]\\d{9}$/", $value);
    }

    /**
     * 验证是否为空
     * 参数: $attribute
     * 参数: $value
     * 参数: $parameters
     * 返回: bool
     */
    public function validateIsNull($attribute, $value, $parameters)
    {
        return empty($value);
    }

    /**
     * 验证用户输入密码是否正确
     * @param $attribute
     * @param $value
     * @param $parameters
     * 返回: mixed
     */
    public function validateCkeckPassword($attribute, $value, $parameters){
        $user = Auth::user(); //获取当前用户
        if(ClientAuth::isApi()){
            return Hash::check($value,  $user->getAuthPassword());
        }else{
            return Auth::validate(['uname' => $user['uname'], 'password' => $value]); //验证
        }

    }


    /**
     * 验证验证码
     * 参数: $attribute
     * 参数: $value
     * 参数: $parameters
     * 返回: bool
     */
    public function validateUserName($attribute, $value, $parameters)
    {
        if(!$value) return true;
        return preg_match("/^[a-zA-Z][A-Za-z0-9_]{1,}$/", $value) &&
            !preg_match("/^[0-9]{1,}$/", $value);
    }

    /**
     * 验证身份证号码
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool|int
     */
    public function validateIsIdcard($attribute, $value, $parameters){
        if(!$value) return true;
        return preg_match("/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/", $value);
    }

    /**
     * 极验验证
     * @return bool
     */
    public function validateGeetest($attribute, $value, $parameters){
        list( $geetest_validate, $geetest_seccode) = array_values(Request::only( 'geetest_validate', 'geetest_seccode'));
        $data = [
            'user_id' => @Auth::user()?@Auth::user()->id:'UnLoginUser',
            'client_type' => 'web',
            'ip_address' => Request::ip()
        ];
        if (SessionService::get('gtserver') == 1) {
            if (Geetest::successValidate($value, $geetest_validate, $geetest_seccode, $data)) {
                return true;
            }
            return false;
        } else {
            if (Geetest::failValidate($value, $geetest_validate, $geetest_seccode)) {
                return true;
            }
            return false;
        }
    }

    /**
     * 发送短信码验证
     */
    public function validateSendCode($attribute, $value, $parameters){
        $value = strval($value);
        if(!$value && $value!=='0') return true;
        $key = Arr::get($parameters,1,'');
        if(!$key){
            return false;
        }
        $sms_codes = SessionService::get($key,['verify_num'=>0]);
        $value = $value.'|'.RequestFacade::get(Arr::get($parameters,0,''),'');
        //认证成功后直接清除前面的短信码
        if(in_array($value,Arr::get($sms_codes,'values',[]))){
            SessionService::forget($key);
            return true;
        }
        $sms_codes['verify_num']++;
        SessionService::put($key,$sms_codes);
        return false;
    }

    /**
     * 验证是否
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function validateUrlPath($attribute, $value, $parameters){
        if(!$value) return true;
        if(Arr::get($parameters,0,'')){ //去掉参数
            $value = explode('?',$value)[0];
        }
        return preg_match("/^[a-z0-9_\/]{0,}[a-z0-9{}\-_\/]{1,}$/", $value);
    }

    /**
     * 验证数组是否完全在数组中
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function validateArrayInArray($attribute, $value, $parameters){
        if(!$value) return true;
        if(!is_array($value)){
            return false;
        }
        return !collect($value)->diff($parameters)->toArray();

    }

    /**
     * 验证数组是否完全在数组中
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function validateArrayKeysInArray($attribute, $value, $parameters){
        if(!is_array($value)){
            return false;
        };
        return $this->validateArrayInArray($attribute, collect($value)->keys()->toArray(), $parameters);
    }

    /**
     * 验证是一维度数组或字符串
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function validateStringOrArray($attribute, $value, $parameters){
        if(!$value || is_string($value)) return true;
        return !collect($value)->filter(function ($item){
            return is_array($item);
        })->count();

    }

    public function validateAlphaDashSpace($attribute, $value,$parameters){
        if (! is_string($value) && ! is_numeric($value)) {
            return false;
        }
        return preg_match('/^[\pL\pM\pN _-]+$/u', $value) > 0;
    }

    /**
     * 验证有效域名
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function validateDomain($attribute, $value,$parameters){
        if (! is_string($value) && ! is_numeric($value)) {
            return false;
        }
        return preg_match('/^((?!-)[A-Za-z0-9-]{1,63}(?<!-)\.)+[A-Za-z]{2,6}$/', $value) > 0;
    }

    /**
     * 银行卡验证
     * 16-19 位卡号校验位采用 Luhm 校验方法计算：
     * 1，将未带校验位的 15 位卡号从右依次编号 1 到 15，位于奇数位号上的数字乘以 2
     * 2，将奇位乘积的个十位全部相加，再加上所有偶数位上的数字
     * 3，将加法和加上校验位能被 10 整除。
     * @param $s
     * @return bool
     */
    public function validateBankCard($attribute, $value, $parameters)
    {
        if (!$value) return true;
        if(!preg_match("/^[0-9]{1,}$/", $value)){
            return false;
        }
        $n = 0;
        $ns = strrev($value); // 倒序
        for ($i = 0; $i < strlen($value); $i++) {
            if ($i % 2 == 0) {
                $n += $ns[$i]; // 偶数位，包含校验码
            } else {
                $t = $ns[$i] * 2;
                if ($t >= 10) {
                    $t = $t - 9;
                }
                $n += $t;
            }
        }
        $res = ($n % 10) == 0;
        $bank_code = Arr::get($parameters, 0, '');

        if (!$bank_code || !$res) { //不验证所属银行代码
            return $res;
        }
        try {
            $url = 'https://ccdcapi.alipay.com/validateAndCacheCardInfo.json';
            $response = \App\Facades\Client::request('get', $url, [
                'query' => [
                    '_input_charset' => 'utf-8',
                    'cardNo' => $value,
                    'cardBinCheck' => 'true'
                ]
            ]);
            if ($response->getStatusCode() == 200) {
                $stringBody = $response->getBody()->getContents();
                $result = json_decode($stringBody, true);
                $res_bank_code = array_get($result, 'bank', '');
                if (array_get($result, 'stat') == 'ok' && $res_bank_code) {
                    $res = array_get($result, 'validated') &&  //有效卡号
                        $bank_code == $res_bank_code
                        //&& //卡号所属银行
                        //array_get($result, 'cardType') == 'DC' //DC-储蓄卡,CC-信用卡
                    ;
                }
            }
        } catch (\Exception $e) {
        }
        return $res;
    }

    /**
     * 社会统一信用码验证
     * @param $code
     * @return bool
     */
    public function validateUnifiedSocialCreditIdentifier($attribute, $code)
    {
        if (is_null($code) || $code==='') return true;
        if (!preg_match('~^[0-9ABCDEFGHJKLMNPQRTUWXY]{18}$~', $code)) {
            return false;
        }
        $code = strtoupper($code);
        // 18位统一社会信用代码不使用I、O、Z、S、V这五个英文字母
        $alphaMap = [
            '0' => 0, '1'  => 1, '2'  => 2, '3'  => 3, '4'  => 4,
            '5' => 5, '6'  => 6, '7'  => 7, '8'  => 8, '9'  => 9,
            'A' => 10, 'B' => 11, 'C' => 12, 'D' => 13, 'E' => 14,
            'F' => 15, 'G' => 16, 'H' => 17, 'J' => 18, 'K' => 19,
            'L' => 20, 'M' => 21, 'N' => 22, 'P' => 23, 'Q' => 24,
            'R' => 25, 'T' => 26, 'U' => 27, 'W' => 28, 'X' => 29,
            'Y' => 30,
        ];
        $weight = [1, 3, 9, 27, 19, 26, 16, 17, 20, 29, 25, 13, 8, 24, 10, 30, 28];
        $chrs   = str_split($code);
        $sum    = 0;
        foreach (array_slice($chrs, 0, 17) as $index => $chr) {
            $sum += $alphaMap[$chr] * $weight[$index];
        }
        $checkNum     = 31 - ($sum % 31);
        $checkNum     = $checkNum == 31 ? 0 : $checkNum;
        $flipAlphaMap = array_flip($alphaMap);
        return $chrs[17] === (string) $flipAlphaMap[$checkNum];
    }




}
