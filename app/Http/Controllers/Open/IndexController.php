<?php

namespace App\Http\Controllers\Open;

use AlibabaCloud\Client\AlibabaCloud;
use App\Facades\ClientAuth;
use App\Facades\Option;
use App\Http\Controllers\Controller;
use App\Models\AiMessage;
use App\Models\Menu;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Overtrue\LaravelWeChat\Facade as EasyWeChat;

class IndexController extends Controller
{


    /**
     * 生成index.html文件生成的数据
     * @return array
     */
    public function indexData(){
        $config_url = (config('laravel_admin.domain_auto')?'':config('app.url')).getRoutePrefix(config('laravel_admin.web_api_model'));
        $config_url = $this->checkUrl($config_url);
        return [
            'time_str'=>'&time='.time(),
            'app_name'=>config('app.name'),
            'config_url'=>$config_url
        ];
    }

    protected function checkUrl($url){
        return (!$url ||
            Str::startsWith($url,'http://') ||
            Str::startsWith($url,'https://') ||
            Str::startsWith($url,'/')
        )?$url:'//'.$url;
    }
    /**
     * 所有页面显示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){
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
        $app_url = config('laravel_admin.domain_auto')?'':config('app.url');
        $app_url = $this->checkUrl($app_url);
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
        //高德地图配置
        $amap_config = [
            'key'=>config('laravel_admin.amap.js_api.key',''),
            'searchUrl'=>'/home/map/search-amap' //高德地图搜索接口
        ];
        //if($data['env']=='local'){
            $amap_config['securityJsCode'] = config('laravel_admin.amap.js_api.secret','');
       /* }else{
            $amap_config['serviceHost']=$app_url.'/_AMapService';
        }*/
        $data['amap_config'] = $amap_config;
        $data['google_config'] = [
            'key'=>config('laravel_admin.google.js_api.key',''),
            'searchUrl'=>'/home/map/search-google' //谷歌地图搜索接口
        ];
        $data['version'] = Option::get('system_version_no','v1.0.0');
        $data['baidu_statistics_url'] = Option::get('baidu_statistics_url','');
        $data['page_gray'] = Option::get('page_gray',0);
        $data['c_j_u'] = collect(str_split(Option::get('crawler_jump_url','')))->filter()->toArray();
        $data['wechat_appid'] = config('wechat.official_account.default.app_id','');
        $max_age = 3600*24;
        $response = Response::returns($data)
            ->header('Cache-Control','max-age='.$max_age)
            ->header('Expires',gmdate('D, d M Y H:i:s ',time()+$max_age).'GMT');
        return $this->addClientId($response,$data['client_id']);
    }

    /**
     * 微信配置
     */
    public function wxConfig()
    {
        $request = Request::instance();
        if(!isset($_SERVER['HTTP_HOST'])){
            $_SERVER['HTTP_HOST']=$request->getHttpHost();
        }
        if(!isset($_SERVER['REQUEST_URI'])){
            $_SERVER['REQUEST_URI']=$request->getRequestUri();
        }
        $officialAccount = EasyWeChat::officialAccount(); // 公众号
        $sdk = $officialAccount->jssdk;
        if ($url = $request->header('Referer')?:config('app.url')) {
            $url = explode('#', $url)[0];
            $sdk->setUrl($url);
        }
        $wxconfig_official = Option::get('wxconfig_official');
        $wxconfig_official = $wxconfig_official ? $wxconfig_official : [
            'title' => config('app.name'),
            'desc' => config('app.name'),
            'imgUrl' => config('app.url').'/dist/img/logo1.png'
        ];
        try {
            $data['wxconfig'] = $sdk->buildConfig([
                'updateAppMessageShareData',
                'updateTimelineShareData',
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo',
                'onMenuShareQZone',
                'chooseWXPay'],  !!config('app.debug'), false, false);
        } catch (\Exception $e) {
            $data['wxconfig'] = [];
            $data['wxconfig_error'] = $e->getMessage();
            Log::channel('daily')->error($e->getMessage());
        }
        $wxconfig_official['link'] = $url;
        $data['show'] = $wxconfig_official;
        return $data;
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
            'length'=>config('captcha.default.length'),
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
            if(!$user->tokenCan('remember')){
                $lifetime = config('laravel_admin.no_remember_lifetime');
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
                'left_margin','right_margin','method','is_out_link'
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
            if(!isset($this->common_responses)){
                $file = storage_path('/developments/api-doc-common.json');
                $this->common_responses = [];
                if(file_exists($file)){
                    $common_responses_data = json_decode(file_get_contents($file),true)?:[];
                    $common_responses = Arr::get($common_responses_data,'common_responses',[]);
                    collect(Arr::get($common_responses_data,'common_responses_list',[]))
                        ->each(function ($item)use(&$common_responses){
                            $common_responses[] = $item;
                            $common_responses[] = [
                                'name'=>'list.'.$item['name'],
                                'description'=>$item['description']
                            ];
                        });
                    $this->common_responses = $common_responses;
                }
            }
            $data['common_responses'] = $this->common_responses;
        }
        $data['menus'] = collect($obj->get())
            ->map(function ($item){
                $item[config('laravel_admin.trans_prefix').'name'] = Menu::trans($item,'name');
                $item[config('laravel_admin.trans_prefix').'description'] = Menu::trans($item,'description');
                return $item;
            });

        return Response::returns($data);
    }

    /**
     * 查询单个菜单详情
     */
    public function menuInfo(){
        $request = app('request');
        $validator = Validator::make($request->all(), [
            'id'=>'required|integer'
        ]);
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }
        $id = app('request')->input('id',0);
        $row = Menu::main()
            ->select(['id'])
            ->with(['route_params','params','body_params','responses'])
            ->find($id);
        return Response::returns(['row'=>$row]);

    }

    public function api404(){
        return Response::returns([
            'errors' => ['roue'=>trans('Routing address error')],
            'message' => trans('The resource you visited does not exist')
        ],404);
    }

    /**
     * 语言读取文字
     * @return void
     * @throws ValidationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function readText(){
        $request = app('request');
        $validator = Validator::make($request->all(), [
            'text'=>'required|min:1|max:30000'
        ]);
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }
        $data = [];
        $data['format'] = 'wav';
        $data['token'] = $this->alibabaToken();
        $data['appkey'] = config('alibaba_cloud.apps.default.AppKey');
        $data['text'] = $request->input('text');
        $data['voice'] = Option::get('voice','zhimiao_emo');
        $client = new Client();
        try {
            $response = $client->post('https://nls-gateway.aliyuncs.com/stream/v1/tts', [
                'body' => json_encode($data)
            ]);
            $content = $response->getBody();
            $path = 'tmp/'.date('Y-m/d/').md5($data['text']).'.wav';
            Storage::disk('public')->put($path,$content);
            $url = Storage::disk('public')->url($path);
            if($id = $request->input('id')){
                AiMessage::query()->where('id',$id)->update([
                    'read_url'=>$url
                ]);
            }
            return Response::returns([
                'url'=>$url
            ]);

        } catch (\Exception $e) {
            return Response::returns([
                'errors' => [$e->getMessage()],
                'message' => '转换音频失败!'
            ],500);
        }
    }

    /**
     * 语音转文字
     * @return void
     */
    public function audioToText(){
        $request = app('request');
        $validator = Validator::make($request->all(), [
            'audio'=>'required|file'
        ]);
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }
        $client = new Client();
        try {
            $appkey = config('alibaba_cloud.apps.default.AppKey');
            $file = $request->file('audio');
            $response = $client->post('https://nls-gateway.aliyuncs.com/stream/v1/asr?appkey='.$appkey, [
                'headers' => [
                    'Content-Type' => 'application/octet-stream',
                    'X-NLS-Token'=>$this->alibabaToken(),
                    'Accept' => '*/*',
                    'Host'=>'nls-gateway.aliyuncs.com'
                ],
                'body' => fopen($file->getRealPath(), 'r'),
            ]);
            if ($response->getStatusCode() === 200) {
                $result = json_decode($response->getBody(), true);
                return Response::returns($result);
            } else {
                return Response::returns([
                    'errors' => ['调用接口出错'],
                    'message' => '转换音频失败!'
                ],500);
            }
        } catch (\Exception $e) {
            return Response::returns([
                'errors' => [$e->getMessage()],
                'message' => '转换音频失败!'
            ],500);
        }
    }

    /**
     * 更新阿里巴巴云应用token
     * @return void
     */
    protected function alibabaToken(){
        $alibaba_token = Cache::get('alibaba_token');
        if($alibaba_token){
            return $alibaba_token;
        }
        \App\Facades\AlibabaCloud::regionId("cn-shanghai")
            ->asDefaultClient();
        try {
            $response = AlibabaCloud::nlsCloudMeta()
                ->v20180518()
                ->createToken()
                ->request();
            $token = $response["Token"];
            if ($token != NULL) {
                $effective = ($token['ExpireTime']-time())-10;
                Cache::put('alibaba_token',$token['Id'],$effective);
                return $token['Id'];
            }
            $message = '获取token失败';
        }catch (\Exception $exception) {
            $message = $exception->getErrorMessage();
        };
        return '';
    }






}
