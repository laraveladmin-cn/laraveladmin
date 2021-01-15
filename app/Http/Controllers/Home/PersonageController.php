<?php

namespace App\Http\Controllers\Home;

use App\Facades\ClientAuth;
use App\Http\Controllers\Controller;
use App\Models\Ouser;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request as ValidateRequest;
use Illuminate\Support\Facades\Validator;

class PersonageController extends Controller
{
    /**
     * 个人资料页面
     * @return mixed
     */
    public function index()
    {
        $user = Auth::user();
        $module = $this->getModule();
        return Response::returns([
            'row'=>$user,
            'configUrl' => [
                'updateUrl'=>'/home/personage/index', //执行修改
                'backUrl'=>'/'.$module.'/index'
            ],
            'maps'=>User::getFieldsMap()
        ]);
    }

    protected function getModule(){
        return collect(explode('/',app('request')->getPathInfo()))->filter()->values()->get(1);
    }

    /**
     * 修改密码页面
     * @return mixed
     */
    public function password()
    {
        $user = Auth::user();
        $module = $this->getModule();
        return Response::returns([
            'row' => [
                'id'=>Arr::get($user,'id'),
                'old_password' => '', //旧密码
                'password' => '', //新密码
                'password_confirmation' => '', //确认新密码
                'ousers'=>Ouser::where('user_id',Arr::get($user,'id'))
                    ->get(['id','type','data'])
                    ->map(function ($item){
                        $item = $item->toArray();
                        $item['data'] = [
                            'nickname'=>Arr::get($item,'data.nickname',''),
                            'avatar'=>Arr::get($item,'data.avatar','')
                        ];
                        return $item;

                }), //三方登录账号信息
                'unbind_ids'=>[],
                'email'=>Arr::get($user,'email',''),
                'mobile_phone'=>Arr::get($user,'mobile_phone','')
            ],
            'configUrl' => [
                'updateUrl'=>'/home/personage/password', //执行修改
                'backUrl'=>'/'.$module.'/index'
            ],
            'maps'=>[
                'ousers'=>Ouser::getFieldsMap()
            ]
        ]);
    }

    /**
     * 执行页面修改
     * @param ValidateRequest $request
     * @return array
     */
    public function putPassword(ValidateRequest $request){
        $rule = $this->getValidateRestPasswordRule();
        $password = $request->input('password');
        $unbind_ids = $request->input('unbind_ids');
        $validator = Validator::make($request->all(), $rule,[],['old_password'=>'旧密码']);
        if ($validator->fails()) {
            return Response::returns([
                'errors' => $validator->errors()->toArray(),
                'message' => 'The given data was invalid.'
            ], 422);
        }
        $user = Auth::user();
        $fields = ['email','mobile_phone'];
        if($password){
            $fields[] = 'password';
        }
        $user->update($request->only($fields));
        if($unbind_ids){
            Ouser::where('user_id',Arr::get($user,'id'))
                ->whereIn('id',$unbind_ids)
                ->update(['user_id'=>0]);
        }
        return ['alert'=>alert(['message'=>'操作成功!'])];
    }

    /**
     * 修改密码重置验证
     * 返回: array
     */
    protected function getValidateRestPasswordRule(){
        return [
            'old_password'=>'required|ckeck_password',
            'password'=>'nullable|between:6,18|confirmed'
        ];
    }

    protected function getValidateIndexRule(){
        $user = Auth::user();
        return [
            'name' => 'required',
            'email' => 'sometimes|required|email|unique:users,email,'.$user['id'].',id,deleted_at,NULL',
            //'mobile_phone' => 'sometimes|required|mobile_phone|unique:users,mobile_phone,'.$user['id'].',id,deleted_at,NULL',
        ];
    }

    /**
     * 修改个人资料
     */
    public function postIndex(\Illuminate\Http\Request $request){
        $validator = Validator::make($request->all(), $this->getValidateIndexRule());
        if ($validator->fails()) {
            return Response::returns([
                'errors' => $validator->errors()->toArray(),
                'message' => 'The given data was invalid.'
            ], 422);
        }
        $user = Auth::user();
        $res = $user->update($request->only(['name','avatar','description'])); //修改个人资料
        if ($res === false) {
            return Response::returns(['alert' => alert(['message' => '修改失败!'], 500)]);
        }
        return Response::returns(['alert' => alert(['message' => '修改成功!'])]);
    }


}
