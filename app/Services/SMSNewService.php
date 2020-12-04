<?php

namespace App\Services;


use Mrgoon\AliSms\AliSms;

class SMSNewService{

    //手机号码
    protected $mobile_phone = '';

    protected $template_code = '';

    protected $params = [];

    protected $aliSms;

    protected $config;

    public function __construct()
    {
        $this->aliSms = new AliSms();
        $this->config = [
            'access_key'=>config('laravel_admin.ali_dayu.app_key'),
            'access_secret'=>config('laravel_admin.ali_dayu.app_secret'),
            'sign_name'=>config('laravel_admin.ali_dayu.signature')
        ];
    }

    /**
     * 短信发送
     * @return false|object
     */
    public function send(){
        return $this->aliSms->sendSms($this->mobile_phone, $this->template_code,$this->params,$this->config);
    }

    public function setRecNum($mobile_phone){
        $this->mobile_phone = $mobile_phone;
        return $this;
    }

    public function setSmsParam($params){
        $this->params = $params;
        return $this;
    }

    public function setSmsFreeSignName(){
        return $this;
    }

    public function setSmsTemplateCode($template_code){
        $this->template_code = $template_code;
        return $this;
    }



}
