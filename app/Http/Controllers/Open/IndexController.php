<?php

namespace App\Http\Controllers\Open;

use App\Facades\ClientAuth;
use App\Http\Controllers\Controller;
use App\Models\Doc;
use App\Models\Feature;
use App\Models\Menu;
<<<<<<< HEAD
use App\Models\Technology;
use Illuminate\Mail\Markdown;
=======
use Illuminate\Support\Arr;
>>>>>>> 8f40fcc86983fe037e1baacc93f671899f11a944
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class IndexController extends Controller
{
    /**
     * 首页数据
     */
    public function getIndex(){
        $data = [
            'features'=>Feature::take(50)->get(),
            'technologys'=>Technology::take(100)->get()
        ];
        return Response::returns($data);
    }

    /**
     * 联系我们
     * @return mixed
     */
    public function contact(){
        $data = [];
        return Response::returns($data);
    }

    /**
     * 生成index.html文件生成的数据
     * @return array
     */
    public function indexData(){
        $file = public_path(getRoutePrefix(config('laravel_admin.web_api_model')).'/home/docs/README.md');
        $markdown = file_exists($file)?file_get_contents($file):Doc::query()->where('name','README.md')->value('description');
        return [
            'time_str'=>'&time='.time(),
            'app_name'=>config('app.name'),
            'markdown'=>Markdown::parse($markdown?:'')
        ];
    }

    /**
     * 所有页面显示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){
        //dd(trans_path('The application language is not set to English to execute','commands'));
        return view('index',$this->indexData());
    }

    /**
     * 404页面
     * @return \Illuminate\Http\Response
     */
    public function page404(){
        return response()->view('index',$this->indexData(),404);
    }

    /**
     * 系统配置数据获取
     * @return mixed
     */
    public function config(){
        $app_url = config('app.url');
        $data['logo'] = config('laravel_admin.logo');
        $data['name'] = config('app.name');
        $data['name_short'] = config('laravel_admin.name_short');
        $data['debug'] = config('app.debug');
        $data['env'] = config('app.env');
        $data['icp'] = config('laravel_admin.icp');
        $data['api_url_model'] =  config('laravel_admin.web_api_model');
        $data['app_url'] = $app_url;
        $data['api_url'] = $app_url.getRoutePrefix();
        $data['web_url'] = $app_url.getRoutePrefix('web');
        $data['domain'] = config('session.domain');
        $data['lifetime']= config('session.lifetime');
        $data['verify'] = config('laravel_admin.verify.type')=='captcha' ? $this->captcha() : $this->geetest(); //验证配置
        $data['client_id'] = ClientAuth::getClient();
        $data['default_language'] = str_replace('_','-',app('translator')->getLocale());
        $data['tinymce_key'] = config('laravel_admin.tinymce_key','');
        $data['locales'] = collect(config('laravel_admin.locales',[]))
            ->prepend(config('app.locale'))
            ->filter()
            ->unique()
            ->map(function ($value){
                return str_replace('_','-',$value);
            })
            ->values()
            ->toArray();
        $data['version'] = 'V1.0.0';
        $max_age = 3600*24;
        $response = Response::returns($data)
            ->header('Cache-Control','max-age='.$max_age)
            ->header('Expires',gmdate('D, d M Y H:i:s ',time()+$max_age).'GMT');
        return $this->addClientId($response,$data['client_id']);
    }

    /**
     * 添加Client-Id
     * @param $response
     * @param $client_id
     * @return mixed
     */
    protected function addClientId($response,$client_id){
        $domain = config('session.domain');
        return $response->cookie(config('laravel_admin.client_id_key'),$client_id,60*365*10,'/',$domain,null,false);
    }

    /**
     * 极验验证
     * @return array
     */
    protected function geetest()
    {
        return [
            'type'=>'geetest',
            'dataUrl'=>config('geetest.url'),
            'data'=>[
                'client_fail_alert'=>config('geetest.client_fail_alert',trans('Validation fails!')),
                'lang'=> app('translator')->getLocale(),
                'product'=>'float',
                'http'=>'http://'
            ]
        ];
    }

    /**
     * 图片验证码
     * @return array
     */
    protected function captcha(){
        return [
            'type'=>'captcha',
            'dataUrl'=> captcha_src(), //验证码图片地址
            'data'=>[],
        ];
    }

    /**
     * 刷新token
     * @return mixed
     */
    public function refreshToken(){
        $data['_token'] = csrf_token()?:'';
        return Response::returns($data);
    }

    /**
     * 获取连接ID标识
     * @return mixed
     */
    public function clientId(){
        $data = ['client_id'=>ClientAuth::getClient()];
        $response = Response::returns($data);
        return $this->addClientId($response,$data['client_id']);
    }

    /**
     * 获取用户信息
     */
    public function user(){
        $user = Auth::user();
        $lifetime = config('session.lifetime');
        if($user){
            $user->load('admin','admin.roles');
            if($user->tokenCan('remember')){
                $lifetime = config('laravel_admin.remember_lifetime')*60*24;
            };
        }
        return Response::returns([
            'user'=>$user,
            'lifetime'=>$lifetime
        ]);
    }

    /**
     * 获取菜单信息
     */
    public function menu(){
        $obj = Menu::main()
            ->select(['id','name','icons','description',
                'url','parent_id','resource_id','status','level',
                'left_margin','right_margin','method',
                'resource_id'
            ])
            ->orderBy('left_margin','asc')
            ->with(['parent'=>function($q){
                $q->select([
                    'id',
                    'name',
                    'item_name'
                ]);
            }]);
        if(Request::input('type')=='document'){
            $obj = $obj->with(['route_params','params','body_params','responses']);
            $file = storage_path('/developments/api-doc.json');
            if(file_exists($file)){
                $common_responses_data = json_decode(file_get_contents($file),true)?:[];
                $common_responses = Arr::get($common_responses_data,'common_responses',[]);
                collect(Arr::get($common_responses_data,'common_responses_list',[]))->each(function ($item)use(&$common_responses){
                    $common_responses[] = $item;
                    $common_responses[] = [
                        'name'=>'list.'.$item['name'],
                        'description'=>$item['description']
                    ];
                });
                $data['common_responses'] = $common_responses;
            }else{
                $data['common_responses'] = [];
            }
        }
        $data['menus'] = collect($obj->get())
            ->map(function ($item){
                $item[config('laravel_admin.trans_prefix').'name'] = Menu::trans($item,'name');
                $item[config('laravel_admin.trans_prefix').'description'] = Menu::trans($item,'description');
                return $item;
        });

        return Response::returns($data);
    }




}
