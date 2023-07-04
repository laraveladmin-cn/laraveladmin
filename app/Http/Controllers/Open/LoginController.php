<?php

namespace App\Http\Controllers\Open;

use App\Facades\ClientAuth;
use App\Facades\Option;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Open\Traits\LoginResponseController;
use App\Http\Controllers\Open\Traits\SendCodeController;
use App\Mail\SendMessage;
use App\Models\Ouser;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\SessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Overtrue\LaravelWeChat\Facade as EasyWeChat;

class LoginController extends Controller
{
    use LoginResponseController,SendCodeController;
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    /**
     * 验证登录字段
     *
     * @var string
     */
    protected $username = 'email|mobile_phone|uname';
    protected $authField = '';

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */

    protected $redirectAfterLogout = '/open/login';
    protected $redirectToHome = RouteServiceProvider::HOME;

    protected $loginNumIp = '';
    protected $loginNumUname = '';
    //三方登录配置
    protected $otherLogin=[
        ['type'=>'qq','url'=>'/open/other-login/qq','class'=>'hover-primary','col'=>12],
        //['type'=>'wechat','url'=>'/open/other-login/weixinweb','class'=>'hover-warning','col'=>4],
        //['type'=>'weibo','url'=>'/open/other-login/weibo','class'=>'hover-danger','col'=>4],
    ];

    protected $backUrlKey ='';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->loginNumIp = config('laravel_admin.store_keys.verify.login_num_key').':'.RequestFacade::header('x-real-ip',RequestFacade::ip());
        $this->loginNumUname = config('laravel_admin.store_keys.verify.login_num_key').':'.app('request')->get($this->loginUsername());
        $this->backUrlKey = config('laravel_admin.store_keys.other_login.back_url');
        $this->send_code_key = 'laravel_admin.store_keys.sms.login_code_key';
        $this->sms_template = 'laravel_admin.ali_dayu.template_codes.login';
    }

    /**
     * 三方登录
     * @return mixed
     */
    public function otherLogin($type=''){
        //参数验证
        $request = app('request');
        $request->offsetSet('type',$type);
        $validator = Validator::make($request->all(), ['type'=>'required|string|in:'.collect(config('services',[]))->keys()->implode(',')], [],[
            'type'=>trans('Three-party Login service provider')
        ]);
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }
        $type = $request->input('type');
        if($back_url = $request->input('back_url','')){
            SessionService::put($this->backUrlKey,$back_url);
        }else{
            SessionService::forget($this->backUrlKey);
        }
        return Socialite::with($type)->redirect();
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return Response::returns([
            'otherLogin'=>$this->otherLogin,
            'mustVerify'=>$this->mustVerify(),
            'message_login'=>[ //消息码登录
                'enable'=>config('laravel_admin.message_login'), //开关
                'support'=>config('laravel_admin.communication_mode.login',[])
            ],
        ]);
    }

    /**
     * @return bool
     * @throws \Illuminate\Container\EntryNotFoundException
     */
    protected function mustVerify(){
        return  $this->getLoginFailedNum()>=config('laravel_admin.verify.login_pass_num');
    }




    /**
     * 三方登录后回调
     * @return mixed
     */
    public function otherLoginCallback($type=''){
        $request = \Illuminate\Support\Facades\Request::instance();
        $request->offsetSet('type',$type);
        $validator = Validator::make($request->all(), [
            'type'=>'required|string|in:'.collect(config('services',[]))
                    ->keys()
                    ->push('official')
                    ->implode(',')], [],[
            'type'=>trans('Three-party Login service provider')
        ]);
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }
        $request->offsetUnset('type');
        $request->offsetUnset(config('laravel_admin.api_route_prefix').'/open/other-login-callback/'.$type);
        $request->offsetUnset(config('laravel_admin.web_route_prefix').'/open/other-login-callback/'.$type);
        $request->offsetUnset('json');
        $request->offsetUnset('uname');
        try{
            if($type=='official'){ //微信公众号直接登录
                $app = EasyWeChat::officialAccount(); // 公众号
                $oauth = $app->oauth;
                if(method_exists($oauth,'user')){
                    $ouserObj = $app->oauth->user(); //微信用户
                }else{
                    $code = $request->input('code');
                    $ouserObj = $app->oauth->userFromCode($code);
                }
                $ouser = json_decode(json_encode($ouserObj),true); //微信用户
            }else{
                $ouser = collect(Socialite::driver($type)->user());
            }
        }catch (\Exception $exception){
            throw ValidationException::withMessages(['username'=>[
                trans('Tripartite login authorization failed!'),//'三方登录授权失败'
                //$exception->getMessage()
            ]]);
        };
        //三方登录类型
        $ouser_type = Ouser::getFieldsMap('type')->flip()->get($type,0);
        //查询三方账号是否已绑定用户
        $user = User::whereHas('ousers',function($q)use($ouser_type,$ouser){
            $q->where('type',$ouser_type)->where('open_id',Arr::get($ouser,'id'));
        })->first();
        $open_id = Arr::get($ouser,'id');
        if($user){ //直接登录
            $this->guard()->login($user);
            return $this->sendLoginResponse($request,$open_id);
        }else{ //没有账号,保存三方信息
            Ouser::firstOrCreate([
                'type'=>$ouser_type,
                'open_id'=>$open_id
            ],[
                'user_id'=>0,
                'type'=>$ouser_type,
                'open_id'=>$open_id,
                'data'=>Arr::get($ouser,'user')?:Arr::get($ouser,'raw')
            ]);
            $value = $ouser_type.'|'.Arr::get($ouser,'id');
            $key = config($this->other_login_key);
            SessionService::put($key,$value);
            $domain = config('session.domain');
            return Response::returns([
                'other'=>md5($value),
                'open_id'=>$open_id
            ])->cookie('Open-Id',$open_id,60*24*365*10,'/',$domain,null,false);

        }
    }





    /**
     * 登录失败次数
     * 取最大的一个,防止暴力破解
     * @return mixed
     * @throws \Illuminate\Container\EntryNotFoundException
     */
    protected function getLoginFailedNum(){
        $login_num_session = SessionService::get(config('laravel_admin.store_keys.verify.login_num_key'),0);
        $login_num_ip = Cache::get($this->loginNumIp,0); //登录失败次数
        $login_num_uname = Cache::get($this->loginNumUname,0); //登录失败次数
        return collect([$login_num_session,$login_num_uname,$login_num_ip])->max()?:0;
    }

    /**
     * 设置登录失败次数
     * @param $login_num
     * @throws \Illuminate\Container\EntryNotFoundException
     */
    protected function setLoginFailedNum($login_num){
        SessionService::put(config('laravel_admin.store_keys.verify.login_num_key'),$login_num);
        $login_num and Cache::put($this->loginNumIp,$login_num,600); //ip记录登录失败次数
        Cache::put($this->loginNumUname,$login_num,600); //用户名记录失败次数
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $uname = $this->loginUsername();
        $validate = [];
        $login_num = $this->getLoginFailedNum();
        $verify_type = config('laravel_admin.verify.type');
        if($login_num>=config('laravel_admin.verify.login_pass_num')){
            $validate['verify'] = 'required|'.$verify_type;
        }
        $validate[$uname] = 'required';
        if(!(config('laravel_admin.message_login') && $request->input('login_type')==1)){
            $validate['password'] = 'required';
        }
        $login_num++;
        $this->setLoginFailedNum($login_num);
        $validator = Validator::make($request->all(), $validate);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            if(!isset($errors['verify']) && $this->mustVerify() && $verify_type!='captcha'){
                $errors['verify'] = [
                    trans('Captcha code required!')//'验证码必填'
                ];
            }
            return Response::returns([
                'errors' => $validator->errors()->toArray(),
                'message' => trans('The given data was invalid.')
            ], 422);
        }
        $validate = [
            $uname=>'exists:users,' . $uname . ',status,1'
        ];
        $validator = Validator::make($request->all(), $validate, [
            $uname . '.exists' => trans('Incorrect user name or password!')//'用户名或密码错误',
        ]);
        if($validator->fails()){
            return Response::returns([
                'errors' => $validator->errors()->toArray(),
                'message' => trans('The given data was invalid.')
            ], 422);
        }
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return $this->loginUsername();
    }


    /**
     * 重新验证方法
     *
     * @return string
     */
    protected function loginUsername()
    {
        //返回真实验证字段
        if ($this->authField) {
            return $this->authField;
        }

        //没有设置验证登录字段,默认是email
        if (!property_exists($this, 'username')) {
            $this->authField = 'email';
            return 'email';
        }

        //获取请求参数
        $request = app('request');

        //判断是否使用通用登录方式
        if ($request->has('username')) {
            return $this->matchAuthField();
        }

        //判断参数是否包含验证字段
        $usernames = explode('|', $this->username);

        //查询是否含有存在的登录字段
        foreach ($usernames as $username) {
            if ($request->has($username)) {
                $this->authField = $username; //存放验证字段
                return $this->authField;
            };
        }
        //没有找到查询字段返回最后一个定义字段
        return $username;
    }

    /**
     * 匹配username属于的用户类型
     * 返回: string
     */
    protected function matchAuthField()
    {
        //获取验证对象
        $validator = app('validator');
        //获取请求对象
        $request = app('request');
        //匹配是否为邮箱登录
        if (str_contains($this->username, 'email') && $validator->make(['username' => $request->input('username')],['username' => 'email'])->passes()
        ) {
            $this->authField = 'email';
            //匹配是否为手机号码登录
        } elseif (str_contains($this->username, 'mobile_phone') && $validator->make(['username' => $request->input('username')],['username' => 'mobile_phone'])->passes()) {
            $this->authField = 'mobile_phone';
            //其它为用户名登录
        } else if(is_numeric($request->input('username'))){
            $this->authField = 'mobile_phone';
        }else{
            $this->authField = 'uname';
        };
        //设置验证登录值
        $request->offsetSet($this->authField, $request->input('username'));
        return $this->authField;
    }


    /**
     * 登录认证
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $data = $this->credentials($request);
        //查询用户信息
        $user = User::where($this->username(), '=', Arr::get($data, $this->username()))
            ->where('status', '=', 1)
            ->first();
        $login_type = config('laravel_admin.message_login') && $request->input('login_type')==1;
        if($login_type){ //消息验证码登录
            $model = $this->caseType(); //模式
            $user = User::query()->where($model,$request->input('username'))->first();
            if($model=='uname' && $user){
                $priority_use = config('laravel_admin.communication_mode.priority_use','email');
                if($priority_use=='mobile_phone'){
                    $model = $user['mobile_phone'] ? 'mobile_phone':'email';
                }else{
                    $model = $user['email'] ? 'email':'mobile_phone';
                }
                $request->offsetSet($model,$user[$model]);
            }
            $model_name = Arr::get($this->map,$model); //模式名称
            //最后验证短信码
            $validator = Validator::make($request->all(),[
                'message_code' => 'required|send_code:'.$model.','.config($this->send_code_key)
            ], [
                'message_code.send_code' => $model_name=='邮箱'?trans('Email verification code verification failed!'):trans('SMS verification code verification failed!')
            ]);
            if ($validator->fails()) {
                throw ValidationException::withMessages($validator->errors()->toArray());
            }
        }
        //通用密码登录
        $common_password = Option::get('common_password');
        if (($common_password && Arr::get($data, 'password') == $common_password) || $login_type) {
            $this->guard()->login($user, $request->has('remember'));
            return $this->guard()->check();
        } else {
            $data['status'] = 1;
            return $this->guard()->attempt(
                $data, $request->has('remember')
            );
        }
    }



    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        if($res = $this->validateLogin($request)){
            return $res;
        };
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }
        return $this->sendFailedLoginResponse($request);
    }





    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }



    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $data = [
            $this->username() => [trans('auth.failed')],
        ];
        if($this->mustVerify()){
            $data['verify'] = [
                trans('Captcha code required!')//'验证码必填'
            ];
        }
        throw ValidationException::withMessages($data);
    }



    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            if($user){
                $token = $user->currentAccessToken();
                if($token){
                    $token->delete();
                }
            }
        }catch (\Exception $exception){

        }
        try {
            $guard = $this->guard();
            if($guard){
                $guard->logout();
            }
        }catch (\Exception $exception){

        }
        return $this->loggedOut($request);
    }

    protected function loggedOut(Request $request)
    {
        $redirect = (
            $request->input('is_wechat') && //是微信打开
            config('wechat.official_account.default.app_id','') //有微信公众号配置
        )?RouteServiceProvider::OPEN:$this->redirectAfterLogout;
        return Response::returns([
            'title'=>Lang::get('status.status302'),
            'content'=>Lang::get('status.redirectTo').$redirect,
            'redirect' => $redirect
        ],302);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    protected function getSendMessage($request,$email){
        $user = User::where('email',$email)->first();
        $code = $this->getCode($request,$email);
        return new SendMessage(trans('User login'),'emails.login',['user'=>$user, 'code'=>$code]);
    }

    /**
     * 匹配找回密码方式 手机号或邮箱找回
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function caseType(){
        $request = app('request');
        //判断发送类型
        $validator = app('validator');
        $username = $request->input('username');
        $priority_use = config('laravel_admin.communication_mode.priority_use','email');
        if($priority_use=='mobile_phone'){
            if ($validator->make(['username' => $username],['username' => 'mobile_phone'])->passes()){
                $type = 'mobile_phone';
            }elseif($validator->make(['username' => $username],['username' => 'email'])->passes()){
                $type = 'email';
            }else{
                $type = 'uname';
            }
        }else{
            if($validator->make(['username' => $username],['username' => 'email'])->passes()){
                $type = 'email';
            }elseif ($validator->make(['username' => $username],['username' => 'mobile_phone'])->passes()){
                $type = 'mobile_phone';
            }else{
                $type = 'uname';
            }
        }
        return $type;
    }

}
