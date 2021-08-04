<?php
/**
 * 菜单模型
 */
namespace App\Models;
use App\Facades\LifeData;
use App\Http\Kernel;
use App\Models\Traits\ExcludeTop;
use App\Models\Traits\TreeModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\BaseModel;
use Illuminate\Support\Str;

class Menu extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $routesConfig = json_decode(file_get_contents(base_path('routes/route.json')),true);
        $this->fieldsShowMaps['group'] = collect(Arr::get($routesConfig,'group',[]))->map(function ($item,$key){
            return $key;
        })->toArray();
        $this->fieldsShowMaps['middleware'] = collect(app(Kernel::class)->getRouteMiddleware())->map(function ($value,$key){
            return $key;
        })->toArray();
    }

    protected $table = 'menus'; //数据表Name
    //软删除,树状结构
    use SoftDeletes,TreeModel,ExcludeTop,BaseModel;
    protected $openRoot = [4]; //游客访问
    protected $homeRoot = [3]; //登录用户
    protected $adminRoot = [2]; //后台菜单
    //批量赋值白名单
    protected $fillable = [
        'id',
        'name',
        'disabled',
        'icons',
        'description',
        'url',
        'parent_id',
        'method',
        'is_page',
        'status',
        'resource_id',
        'group',
        'action',
        'env',
        'plug_in_key',
        'use',
        'as',
        'middleware',
        'item_name'
    ];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];

    /**
     * 字段值map
     * @var array
     */
    protected $fieldsShowMaps = [
        'method'=>[
            1=>'get',
            2=>'post',
            4=>'put',
            8=>'delete',
            16=>'head',
            32=>'options',
            64=>'trace',
            128=>'connect',
            256=>'patch'
        ],
        'is_page'=>[
            'No',
            'Yes'
        ],
        'status'=>[
            1=>'Display',
            2=>'No display'
        ],
        'disabled'=>[
            0=>'Enable',
            1=>'Disable'
        ],
        'use'=>[
            1=>'api',
            2=>'web'
        ],
        'env'=>[
            'local'=>'local',
            'testing'=>'testing',
            'staging'=>'staging',
            'production'=>'production'
        ]
    ];

    /**
     * 字段默认值
     * @var array
     */
    protected $fieldsDefault = [
        'name'=>'',
        'icons'=>'',
        'url'=>'',
        'description'=>'',
        'parent_id'=>0,
        'method'=>[1],
        'is_page'=>0,
        'status'=>2,
        'disabled'=>0,
        'resource_id'=>0,
        'group'=>'',
        'action'=>'',
        'env'=>'',
        'plug_in_key'=>'',
        'as'=>'',
        'middleware'=>[],
        'use'=>[],
        'item_name'=>''
    ];

    //字段默认值
    protected $fieldsName = [
        'name' => 'Name',
        'icons' => 'Icon',
        'description' => 'Describe',
        'url' => 'URL path',
        'parent_id' => 'Parent ID',
        'method' => 'Request method',
        'is_page' => 'Is it a page',
        'disabled' => 'Functional status',
        'status' => 'State',
        'level' => 'Hierarchy',
        'resource_id'=>'Resource ID',
        'group'=>'Group',
        'action'=>'Binding controller method',
        'env'=>'Use environment',
        'plug_in_key'=>'Plug in menu unique ID',
        'use'=>'Route usage',
        'as'=>'Routing alias',
        'middleware'=>'Using middleware alone',
        //'left_margin' => 'Left boundary',
        //'right_margin' => 'Right boundary',
        //'created_at' => 'Created At',
        //'updated_at' => 'Updated At',
        //'deleted_at' => 'Deleted At',
        'id' => 'ID',
    ];

    /**
     * 所属资源
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function resource(){
        return $this->belongsTo('App\Models\Menu');
    }

    /**
     * 所属资源
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function resources(){
        return $this->hasMany('App\Models\Menu','resource_id','id');
    }

    /**
     * 菜单-角色
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(){
       return $this->belongsToMany('App\Models\Role');
    }


    /**
     * 菜单-操作日志
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs(){
        return $this->hasMany('App\Models\Log');
    }

    /**
     * 获取多选值
     * @param  $value
     * @return  array
     */
    public function getMethodAttribute($value)
    {
        $field = $this->getFieldsMap('method')->toArray();
        unset($field[0]);
        return multiple($value,$field);
    }

    /**
     * 设置多选值
     * @param  $value
     * @return  array
     */
    public function setMethodAttribute($value)
    {
        $this->attributes['method'] = multipleToNum($value);
    }

    /**
     * 获取多选值
     * @param  $value
     * @return  array
     */
    public function getUseAttribute($value)
    {
        $field = $this->getFieldsMap('use')->toArray();
        unset($field[0]);
        return multiple($value,$field);
    }

    /**
     * 设置多选值
     * @param  $value
     * @return  array
     */
    public function setUseAttribute($value)
    {
        $this->attributes['use'] = multipleToNum($value);
    }

    /**
     * 获取多选值
     * @param  $value
     * @return  array
     */
    public function getMiddlewareAttribute($value)
    {
        $res = $value?json_decode($value,true):[];
        return $res?:[];
    }

    /**
     * 设置多选值
     * @param  $value
     * @return  array
     */
    public function setMiddlewareAttribute($value)
    {
        $this->attributes['middleware'] = (is_array($value) && $value)?json_encode($value):'';
    }

    /**
     * 接口参数
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function params(){
        return $this->hasMany('App\Models\Param')
            ->where('use',0);
    }

    /**
     * 接口body参数
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function body_params(){
        return $this->hasMany('App\Models\Param')
            ->where('use',1);
    }

    /**
     * 接口响应说明
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responses(){
        return $this->hasMany('App\Models\Response');
    }

    /**
     * 可使用的菜单
     * @param $query
     */
    public function scopeUsable($query){
        $query->where('disabled','=',0)->where(function ($q){
            $q->where('env',config('app.env'))
                ->orWhere('env','');
        });
    }

    public function menu_roles(){
        return $this->hasMany('App\Models\MenuRole');
    }

    /**
     * Request method对应数据值
     * @param $query
     * @param $method
     * @return mixed
     */
    public function scopeMethodValue($query,$method){
        if(is_array($method)){
            return collect($method)->map(function ($value){
                return Arr::get(array_flip(self::getFieldsMap('method')->toArray()),strtolower($value),0);
            })->toArray();
        }
        return Arr::get(array_flip(self::getFieldsMap('method')->toArray()),strtolower($method),0);
    }

    /**
     * 我拥有的权限
     */
    public function scopeMain($query)
    {
        //可用菜单
        $query->usable();
        //登录用户
        $user = Auth::user();
        //超级管理员
        if ($user && Role::isSuper()) {
            return $query;
        }

        //游客
        $query->where(function ($q){
            collect(Menu::whereIn('id',$this->openRoot)->get())
                ->map(function ($menu,$index)use(&$q){
                    if($index==0){
                        $q->where(function ($q)use($menu){
                            $q->where('left_margin','>=',$menu['left_margin'])
                                ->where('right_margin','<=',$menu['right_margin']);
                        });
                    }else{
                        $q->orWhere(function ($q)use($menu){
                            $q->where('left_margin','>=',$menu['left_margin'])
                                ->where('right_margin','<=',$menu['right_margin']);
                        });
                    }
                });
        });

        //登录用户
        if($user){
            $query->orWhere(function ($q){
                $q->mainHome();
            });
        }

        //后台用户
        if(User::isAdmin()){
            $query->orWhere(function ($q){
                $q->mainAdmin();
            });
        }
        return $query;
    }

    public function scopeModule($q,$ids){
        collect(Menu::whereIn('id',$ids)->get())
            ->map(function ($menu,$index)use(&$q){
                if($index==0){
                    $q->where(function ($q)use($menu){
                        $q->where('left_margin','>=',$menu['left_margin'])
                            ->where('right_margin','<=',$menu['right_margin']);
                    });
                }else{
                    $q->orWhere(function ($q)use($menu){
                        $q->where('left_margin','>=',$menu['left_margin'])
                            ->where('right_margin','<=',$menu['right_margin']);
                    });
                }
            });
        return $q;
    }

    /**
     * 我的前端
     * @param $q
     * @return mixed
     */
    public function scopeMainHome($q){
        $q->module($this->homeRoot);
        return $q;
    }

    /**
     * 我的后台
     * @param $q
     * @return mixed
     */
    public function scopeMainAdmin($q){
        //超级管理员
        if (Role::isSuper()) {
            return $q->module($this->adminRoot);
        }
        $q->module($this->adminRoot)
            ->whereHas('menu_roles', function ($q) {
            $q->whereIn('role_id',Role::getRoleIds());
        });
        return $q;
    }




    /**
     * 我拥有的权限
     */
    public function scopeGetMain($query)
    {
        return LifeData::remember('_menus_main',function ()use($query){
            return collect($query->main()
                ->orderBy('left_margin','asc')
                ->get())->toArray();
        });
    }


    /**
     * 判断当前用户是否拥有某权限
     * @param $url
     * @return bool
     */
    public function scopeHasPermission ($query,$url,$method='get',$is_bool=true){
        return self::isUrlInMenus($url,self::getMain(),$method,$is_bool);
    }

    /**
     * 获取权限地址
     * @param $query
     * @param $url
     * @return string
     */
    public function scopeRealRoute($query,$url){
        $url = Str::start($url,'/');
        $route_prefix = getRoutePrefix();
        $route_prefix_web = getRoutePrefix('web');
        if($route_prefix && Str::is($route_prefix.'/*',$url)){
            $url = Str::replaceFirst($route_prefix,'',$url);
        }elseif($route_prefix && Str::is($route_prefix_web.'/*',$url)){
            $url = Str::replaceFirst($route_prefix_web,'',$url);
        }
        return $url;
    }

    /**
     * 判断url是否在菜单目录里
     * @param $url
     * @param $menus
     * @return bool
     */
    public function scopeIsUrlInMenus($query,$url,$menus,$method='get',$is_bool=true){
        $url = self::realRoute($url);
        $method = self::methodValue($method);
        $isIn = false;
        $menus = collect($menus)->filter(function($item) use (&$isIn,$url,$method,&$menu){
            return strpos($item['url'],$url)===0 && in_array($method,$item['method']);
        });
        $menu = collect($menus)->first(function ($item)use($url){
            return $item['url']==$url;
        })?:(collect($menus)->first()?:[]);
        $menu and $isIn=true;
        return $is_bool?$isIn:$menu;
    }

    /**
     * 兼容解码值
     * @param $query
     */
    public function scopeDecodeValue($query,&$item){
        //解码
        collect(['method','disabled','status','is_page','use'])->map(function ($key)use(&$item){
            if(!isset($item[$key])){
                return;
            }

            $val = Arr::get($item,$key);
            $map = Arr::get($this->fieldsShowMaps,$key);
            if(!is_null($val)){
                if(is_array($val)){
                    $m = collect($map)->flip();
                    $item[$key] = collect($val)->map(function ($v)use($key,$m){
                        return $m->get($v,$v);
                    })->toArray();
                }elseif(!collect($map)->keys()->map(function ($val){
                    return $val.'';
                })->contains($val)){
                    $default = $key=='method'?0:Arr::get($this->fieldsDefault,$key);
                    $item[$key] = collect($map)->flip()->get($val,$default);
                }
            }
        });
        return $item;
    }

    /**
     * 翻译自动生成的资源路由
     * @param $q
     * @param $item
     * @param $key
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function scopeTrans($q, $item, $key)
    {
        $value = Arr::get($item, $key, '');
        $resource_id = Arr::get($item, 'resource_id', 0);
        $res = trans_path($value, '_shared.menus');
        if ($resource_id && $res == $value && (str_contains($value, '{') || app('translator')->getLocale() != 'en')) { //没有翻译成功
            $parent_name = Arr::get($item, 'parent.item_name', '') ?: Arr::get($item, 'parent.name', '');
            $key = str_replace($parent_name, '{name}', $value);
            $data = [];
            if (Str::startsWith($key, '{name}')) {
                $data['name'] = trans_path($parent_name, '_shared.menus');
            } else {
                $key = str_replace(strtolower($parent_name), '{name}', $value);
                $key = str_replace('{name}', '{l_name}', $key);
                $data['l_name'] = trans_path($parent_name, '_shared.menus');
            }
            $res = trans_path($key, '_shared.menus',$data);
        }
        return $res;
    }


}
