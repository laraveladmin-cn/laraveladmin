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
        if(!$value) return true;
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




}
