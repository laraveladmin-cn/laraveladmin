<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Open\Traits\SendCodeController;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    use SendCodeController;
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 忘记密码页面展示数据
     * @return array
     */
    public function index(){
        return Response::returns([]);
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
        if($validator->make(['username' => $username],['username' => 'email'])->passes()){
            $type = 'email';
        }elseif ($validator->make(['username' => $username],['username' => 'mobile_phone'])->passes()){
            $type = 'mobile_phone';
        }else{
            $type = 'uname';
        }
        return $type;
    }

    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule(Request $request,$model)
    {
        $validate = [
            'password' => 'required|string|min:6,max:16|confirmed', //密码
            'password_confirmation' => 'required', //确认密码
        ];
        $validate['username'] = 'required|exists:users,'.$model.',deleted_at,NULL';//用户名是否存在
        if($this->moreVerifyNum()){
            $validate['verify'] = 'required|'.config($this->verify_type); //验证码
        }
        return $validate;
    }

    /**
     * 重置密码
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function resetPassword(Request $request){
        $model = $this->caseType(); //模式
        $validate = $this->getValidateRule($request,$model); //验证规则
        $user = User::where($model,$request->input('username'))->first();
        if($model=='uname' && $user){
            $model = $user['email'] ? 'email':'mobile_phone';
        }
        $model_name = Arr::get($this->map,$model); //模式名称
        //验证
        $validator = Validator::make($request->all(), $validate, [
            'verify.required' => '验证码必填',
            'verify.geetest' => '验证码验证失败',
            'verify.captcha' => '验证码验证失败'
        ], [
            'verify' => '验证码',
            'username'=>'用户'
        ]);
        if ($validator->fails()) {
            return Response::returns([
                'errors' => $validator->errors()->toArray(),
                'message' => 'The given data was invalid.'
            ], 422);
        }
        //最后验证短信码
        $validator = Validator::make($request->all(),[
            'message_code' => 'required|send_code:username,'.config($this->send_code_key)
        ], [
            'message_code.send_code' => $model_name.'验证码验证失败'
        ], ['message_code' => $model_name.'验证码']);
        if ($validator->fails()) {
            return Response::returns([
                'errors' => $validator->errors()->toArray(),
                'message' => 'The given data was invalid.'
            ], 422);
        }
        if($user->update(['password'=> $request->input('password')])===false){
            return Response::returns(['alert' => alert(['message' => '操作失败!'], 500)],500);
        };
        return orRedirect('/open/login');
    }
}
