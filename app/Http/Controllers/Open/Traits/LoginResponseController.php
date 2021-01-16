<?php


namespace App\Http\Controllers\Open\Traits;

use App\Facades\Formatter;
use App\Models\Menu;
use App\Models\Ouser;
use App\Services\FormatterService;
use App\Services\SessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Request as RequestFacade;

trait LoginResponseController
{

    protected $redirectTo = '/admin/index';
    protected $redirectToTourist = '/open/index'; //游客跳转
    protected $other_login_key = 'laravel_admin.store_keys.other_login.key';
    protected function setLoginFailedNum($login_num){

    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        //用户数据记录
        $this->setLoginFailedNum(0);
        //如果是登录并绑定
        $user = Auth::user();
        $this->bindOuser($user);
        $remember = $request->has('remember');
        $lifetime = $remember?config('laravel_admin.remember_lifetime')*60*24:config('session.lifetime');
        if($remember){
            $rememberTokenCookieKey = Auth::getRecallerName();
            Cookie::queue($rememberTokenCookieKey, Cookie::get($rememberTokenCookieKey), $lifetime);
        }
        if(Arr::get($user,'admin') ){
            $hasPermission = Menu::hasPermission($this->redirectTo,'get',false);
            if(!$hasPermission){
                $this->redirectTo = Menu::mainAdmin()->where('is_page',1)->orderBy('left_margin','asc')->value('url');
            }
            $redirect = $this->redirectTo;
        }else{
            $redirect = $this->redirectToTourist;
        }
        $token = $user->createToken('apiToken',$remember?['remember']:['*'])->plainTextToken;
        $domain = config('session.domain');
        return Response::returns([
            'token'=>$token,
            'redirect' => $redirect,
            'lifetime'=>$lifetime
        ],200)->cookie('Authorization','Bearer '.$token,$lifetime,'/',$domain,null,false);
    }

    /**
     * 数据结构
     * @var array
     */
    protected $ouserFormatter=[
        'qq'=>[
            'name'=>'nickname', //名称
            'gender'=>'gender', //性别
            'country'=>'$def:', //国家
            'province'=>'province', //省份
            'city'=>'city', //城市
            'year'=>'year', //生日
            'avatar'=>'figureurl_2' //头像
        ],
        'weibo'=>[
            'name'=>'name', //名称
            'gender'=>'gender', //性别
            'province'=>'province', //省份
            'country'=>'$def:', //国家
            'city'=>'city', //城市
            'avatar'=>'avatar_hd', //头像
            'description'=>'description'
        ],
        'official'=>[
            'name'=>'nickname', //名称
            'gender'=>'original.sex', //性别
            'country'=>'country', //国家
            'province'=>'province', //省份
            'city'=>'city', //城市
            'avatar'=>'headimgurl' //头像
        ],
        'weixinweb'=>[
            'name'=>'nickname', //名称
            'gender'=>'sex', //性别
            'country'=>'country', //国家
            'province'=>'province', //省份
            'city'=>'city', //城市
            'avatar'=>'headimgurl' //头像
        ]
    ];

    /**
     * 解码字典
     * @var array
     */
    protected $ouserMaps=[
        'qq'=>[],
        'weibo'=>[
            'gender'=>[
                'm'=>'男',
                'f'=>'女'
            ]
        ],
        'official'=>[
            'gender'=>[
                '1'=>'男',
                '2'=>'女'
            ]
        ],
        'weixinweb'=>[
            'gender'=>[
                '1'=>'男',
                '2'=>'女'
            ]
        ]

    ];


    /**
     * 绑定三方账号
     */
    protected function bindOuser($user){
        $other = RequestFacade::get('other');
        $session_other = SessionService::get(config($this->other_login_key));
        if($other && md5($session_other)==$other){
            $session_others = explode('|',$session_other);
            //查询三方数据
            $ouser = Ouser::where('type',Arr::get($session_others,0))
                ->where('open_id',Arr::get($session_others,1))
                ->where('user_id',0)
                ->first();
            if($ouser){
                $data = $this->handleOuserData(Arr::get($ouser,'data',[]),$ouser['type']);
                if($data){
                    //用户未录入信息
                    $keys = collect($user)->filter(function ($value){
                        return is_null($value) || $value==='';
                    })->keys();

                    //三方登录信息数据格式转换
                    $types = Ouser::GetFieldsMap('type');
                    $data = collect(Formatter::render(Arr::get($this->ouserFormatter,$types[$ouser['type']],[]),$data,$data))
                        ->filter(function ($value){
                            return !is_null($value) && $value!=='';
                    })->toArray();
                    //数据码值解码
                    $data = Formatter::decode($data,Arr::get($this->ouserMaps,$types[$ouser['type']],[]));
                    //数据解码成我方系统识别值

                    //只需要填入用户未录入信息的信息
                    $data = collect($data)->only($keys)->toArray();
                    $data and $user->update($data);
                }
                $ouser->update(['user_id'=>Arr::get($user,'id')]);
            }
        }
    }

    protected function handleOuserData($data,$type){
        if($type==3){ //微博
            $location = explode(' ',Arr::get($data,'location',''));
            $data['province'] = Arr::get($location,0,'');
            $data['city'] = Arr::get($location,1,'');
        }
        return $data;
    }

}
