<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Open\Traits\LoginResponseController;
use App\Mail\SendMessage;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Open\Traits\SendCodeController;


class RegisterController extends Controller
{
    use SendCodeController,LoginResponseController;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    protected $redirectTo = '/admin/index'; //内勤人员跳转
    protected $redirectAfterLogout = '/open/login'; //未登录跳转登录
    protected $redirectToHome = '/home/index'; //代理人跳转
    protected $emailActivateTime = 3600; //注册邮箱激活失效时间

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('activateByEmail');
        $this->send_code_key = 'laravel_admin.store_keys.sms.code_key';
        $this->sms_template = 'laravel_admin.ali_dayu.template_codes.register';
        $this->sms_key='mobile_phone';
        $this->email_key = 'email';
    }

    /**
     * 注册页面展示数据
     * @return array
     */
    public function index(){
        return [];
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

    protected function initValidate($type,$uname=false){
        return [
            $type => 'required|'.$type.'|unique:users,'.$type, //手机号
            'verify' => 'required|'.config($this->verify_type) //验证码
        ];
    }

    protected function getSendMessage($request){
        $code = $this->getCode($request,$request->input($this->email_key));
        return new SendMessage('用户注册','emails.register',['code'=>$code]);
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Request $request)
    {
        $validator = [
            'username' => 'required|alpha_dash|between:6,18|unique:users,uname', //用户名
            'password' => 'required|string|min:6|confirmed', //密码
            'password_confirmation' => 'required', //确认密码
            'agree' => 'accepted',
            'email'=>'sometimes|string|email|max:255|unique:users,email',
            'mobile_phone'=>'sometimes|mobile_phone|unique:users,mobile_phone'
        ];
        //手机号邮箱必填一个
        if(!$request->input('mobile_phone') && !$request->input('email')){
            $validator['email'] = 'required|string|email|max:255|unique:users,email'; //电子邮箱
        };
        if($this->moreVerifyNum()){
            $validate['verify'] = 'required|'.config($this->verify_type); //验证码
        }
        return Validator::make($request->all(), $validator, [
            'username.unique' => '用户名已存在',
            'email.unique' => '电子邮箱已被使用了',
            'mobile_phone.mobile_phone' => '请正确填写手机号',
            'verify.geetest' => '验证码验证失败',
            'verify.captcha' => '验证码验证失败'
        ], [
            'uname' => '用户名',
            'email' => '电子邮箱',
            'mobile_phone' => '手机号',
            'verify'=>'验证码'
        ]);
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request)->validate();
        $model = $this->caseType(); //模式
        $model_name = Arr::get($this->map,$model); //模式名称
        //最后验证短信码
        $validator = Validator::make($request->all(), [
            'message_code' => 'required|send_code:'.$model.','.config($this->send_code_key)
        ], [
            'message_code.send_code' => $model_name.'验证码验证失败'
        ], ['message_code' => $model_name.'验证码']);
        if ($validator->fails()) {
            return Response::returns([
                'errors' => $validator->errors()->toArray(),
                'message' => 'The given data was invalid.'
            ], 422);
        }
        $data = $request->all();
        $data['status'] = 1;
        $data['uname'] = $data['username'];
        event(new Registered($user = User::create($data)));
        $this->bindOuser($user);
        if(config('laravel_admin.register_login')){
            Auth::guard()->login($user);
            return $this->sendLoginResponse($request);
        }else{
            return Response::returns([
                'alert' => alert(['message' => '注册成功!']),
                'redirect' => $this->redirectAfterLogout
            ],200);
        }

    }

}
