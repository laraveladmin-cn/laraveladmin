<?php


namespace App\Http\Controllers\Open\Traits;


use App\Facades\SMS;
use App\Jobs\SendSms;
use App\Mail\SendMessage;
use App\Models\User;
use App\Services\SessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait SendCodeController
{
    protected $send_code_key='laravel_admin.store_keys.sms.forgot_password_key';
    protected $forbidden = 'laravel_admin.store_keys.sms.forbidden';
    protected $refuse_num = 'laravel_admin.store_keys.sms.refuse_num';
    protected $refuse_time = 'laravel_admin.store_keys.sms.refuse_time';
    protected $verify_num = 'laravel_admin.store_keys.sms.verify_num';
    protected $sms_template = 'laravel_admin.ali_dayu.template_codes.forgot';
    protected $verify_type = 'laravel_admin.verify.type';
    protected $sms_key='username';
    protected $email_key='username';

    //验证码随机字符串范围
    protected $characters = '0123456789';
    //验证码长度
    protected $code_length=6;
    protected $map = [
        'email'=>'邮件',
        'mobile_phone'=>'短信'
    ];


    /**
     * Generate captcha text
     *
     * @return string
     */
    protected function generate()
    {
        $characters = str_split($this->characters);
        $bag = '';
        for($i = 0; $i < $this->code_length; $i++)
        {
            $bag .= $characters[rand(0, count($characters) - 1)];
        }
        return $bag;
    }

    /**
     * 匹配找回密码方式 手机号或邮箱找回
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function caseType(){
        if(app('request')->input('email')){
            return 'email';
        };
        return 'mobile_phone';
    }

    /**
     * 发送验证码通知
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function send(Request $request){
        $type = $this->caseType();
        return $type=='mobile_phone'?  $this->sendSMS($request):$this->sendEmail($request,$type=='uname');
    }

    /**
     * 获取并存储验证码
     */
    protected function getCode(Request $request,$username){
        //生成短信验证码并存放
        $code = $this->generate();
        $codes['time'] = time();
        $codes['values'][] = $code . '|' . $username;
        $codes['verify_num'] = 0; //验证次数
        SessionService::put(config($this->send_code_key), $codes);
        return $code;
    }

    /**
     * 获取存储的验证码信息
     */
    protected function getStorageCode(){
       return SessionService::get(config($this->send_code_key), []);
    }


    protected function initValidate($type,$uname=false){
        $validate = ['verify' => 'required|'.config($this->verify_type)]; //验证码
        if($uname){
            $validate['username'] = 'required|alpha_dash|between:5,18|exists:users,uname,deleted_at,NULL';
        }else{
            $validate['username'] = 'required|'.$type.'|exists:users,'.$type.',deleted_at,NULL';
        }
        return $validate;
    }

    protected function getSendMessage($request){
        $email = $request->input($this->email_key);
        $user = User::where('email',$email)->first();
        $code = $this->getCode($request,$email);
        return new SendMessage('找回密码','emails.forgot_password',['user'=>$user, 'code'=>$code]);
    }

    /**
     * 发送忘记密码验证邮件
     */
    public function sendEmail(Request $request,$uname=false){
        if($response = $this->sendValidate($request,'email',$uname)){
            return $response;
        };
        $email = $request->input($this->email_key);
        if($uname){
            $email = User::where('uname',$email)->value('email');
            if(!$email){
                throw ValidationException::withMessages(['username'=>['电子邮箱未设置']]);
            }
        }
        Mail::to($email)->queue($this->getSendMessage($request)->onQueue('send_message'));
        return Response::returns([
            'title' => '邮件正在发送...',
            'countdown' => config($this->forbidden)
        ]);
    }

    /**
     * 发送忘记密码验证短信
     */
    public function sendSMS(Request $request,$uname=false){
        if($response = $this->sendValidate($request,'mobile_phone',$uname)){
            return $response;
        };
        //短信内容
        $mobile_phone = $request->input($this->sms_key);
        $sms = SMS::setRecNum($mobile_phone)
            ->setSmsParam(['code' => $this->getCode($request,$mobile_phone)])
            ->setSmsTemplateCode(config($this->sms_template));

        //异步队列发送短信
        $job = (new SendSms($sms))->onQueue('send_message');
        $this->dispatch($job);
        return Response::returns([
            'title' => '短信正在发送...',
            'countdown' => config($this->forbidden)
        ]);
    }

    /**
     * 验证
     * @param Request $request
     * @param $validate
     * @param string $type
     * @return mixed
     */
    protected function sendValidate(Request $request,$type='email',$uname=false){
        $validate = $this->initValidate($type,$uname);
        //验证码及上传验证码发送时间
        $codes = $this->getStorageCode();
        isset($codes['time']) or $codes['time'] = 0;
        $now = time();
        if (count(Arr::get($codes, 'values',[])) >= config($this->refuse_num, 1) && Arr::get($codes,'time') + config($this->refuse_time) > $now) {
            return Response::returns([
                'message' => '拒绝发送'.Arr::get($this->map,$type),
                'errors' => [
                    $type.'_code' => ['你操作太频繁,请稍后再试']
                ]
            ], 422);
        }
        //正在发送短信验证码
        if ($codes && $codes['time'] + config($this->forbidden) > $now) {
            return Response::returns([
                'title' => Arr::get($this->map,$type).'正在发送...',
                'countdown' => $codes['time'] + config($this->forbidden) - $now
            ]);
        }

        //验证
        $validator = Validator::make($request->all(), $validate, [
            'verify.required' => '验证码必填',
            'verify.geetest' => '验证码验证失败',
            'verify.captcha' => '验证码验证失败',
            'email.exists'=>'邮箱地址错误',
            'mobile_phone.exists'=>'手机号码错误',
            'mobile_phone.mobile_phone' => '请正确填写手机号',
            'mobile_phone.unique' => '该手机号已经注册过了'
        ], [
            'verify' => '验证码',
            'uname'=>'用户名',
            'mobile_phone'=>'手机号码'
        ]);
        if ($validator->fails()) {
            return Response::returns([
                'errors' => $validator->errors()->toArray(),
                'message' => 'The given data was invalid.'
            ], 422);
        }

    }

    /**
     * 超过验证次数
     * @return bool
     */
    protected function moreVerifyNum(){
        $codes = $this->getStorageCode();
        return $codes && Arr::get($codes,'verify_num')>config($this->verify_num);
    }



}
