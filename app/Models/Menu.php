<?php
/**
 * 菜单模型
 */
namespace App\Models;
use App\Facades\LifeData;
use App\Http\Kernel;
use App\Models\Traits\ExcludeTop;
use App\Models\Traits\TreeModel;
use App\Models\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * App\Models\Menu
 *
 * @property int $id ID
 * @property string $name 名称@required
 * @property string $icons 图标@nullable|alpha_dash
 * @property string $description 描述$textarea
 * @property string $url URL路径
 * @property int $parent_id 父级ID@sometimes|required|exists:menus,id
 * @property array $method 请求方式:1-get,2-post,4-put,8-delete,16-head,32-options,64-trace,128-connect$checkbox@required|array
 * @property int $is_page 是否为页面:0-否,1-是$radio@in:0,1
 * @property int $disabled 功能状态:0-启用,1-禁用$radio@in:0,1
 * @property int $status 状态:1-显示,2-不显示$radio@in:1,2
 * @property int $resource_id 所属资源
 * @property string $group 后台路由所属组
 * @property string $action 绑定控制器方法
 * @property string $env 使用环境
 * @property string $plug_in_key 插件菜单唯一标识
 * @property int $level 层级
 * @property int $left_margin 左边界
 * @property int $right_margin 右边界
 * @property array $use 路由使用地方:1-api,2-web
 * @property string $as 路由别名
 * @property array $middleware 单独使用中间件
 * @property string $item_name 资源名称
 * @property int $is_out_link 是否为外部链接:0-否,1-是
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Param[] $body_params
 * @property-read int|null $body_params_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Menu[] $childrens
 * @property-read int|null $childrens_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Log[] $logs
 * @property-read int|null $logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MenuRole[] $menu_roles
 * @property-read int|null $menu_roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Param[] $params
 * @property-read int|null $params_count
 * @property-read Menu|null $parent
 * @property-read Menu|null $resource
 * @property-read \Illuminate\Database\Eloquent\Collection|Menu[] $resources
 * @property-read int|null $resources_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Response[] $responses
 * @property-read int|null $responses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Param[] $route_params
 * @property-read int|null $route_params_count
 * @method static \Illuminate\Database\Eloquent\Builder|Menu children($node, $self = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu commaMapValue($key)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu decodeValue($item)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu getClassName()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu getFieldsDefault($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Menu getFieldsMap($key = '', $decode = false, $trans = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu getFieldsName($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Menu getFillables()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu getItemName()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu getMain()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu getTableComment()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu getTableInfo()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu getTableName()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu getTreeField()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu hasPermission($url, $method = 'get', $is_bool = true)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu hasPermissionPath(string $path, string $method = 'get', string $is_bool = true)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu ignoreUpdateAt()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu insertReplaceAll($datas)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu isUrlInMenus($url, $menus, $method = 'get', $is_bool = true)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu main()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu mainAdmin()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu mainDB()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu mainHome()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu methodValue($method)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu module($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu notModule($ids)
 * @method static \Illuminate\Database\Query\Builder|Menu onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu optionalParent($node = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu options(array $options = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Menu optionsWhere($where = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Menu parents(bool $node, bool $self = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu realRoute($url)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu trans($item, $key)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu usable()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereAs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereDisabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereEnv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereIcons($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereIsOutLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereIsPage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereItemName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereLeftMargin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereMiddleware($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu wherePlugInKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereResourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereRightMargin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUse($value)
 * @method static \Illuminate\Database\Query\Builder|Menu withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Menu withoutTrashed()
 * @mixin \Eloquent
 */
class Menu extends Model
{
  /*  public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $routesConfig = json_decode(file_get_contents(base_path('routes/route.json')),true);
        $this->fieldsShowMaps['group'] = collect(Arr::get($routesConfig,'group',[]))->map(function ($item,$key){
            return $key;
        })->toArray();
        $this->fieldsShowMaps['middleware'] = collect(app(Kernel::class)->getRouteMiddleware())->map(function ($value,$key){
            return $key;
        })->toArray();
    }*/

    protected $table = 'menus'; //数据表Name
    //软删除,树状结构
    use SoftDeletes,TreeModel,ExcludeTop,BaseModel,UsesUuid;

    public $incrementing = false;
/*    public $openRoot = [4=>'d423c2e2-aed7-11ee-9216-0242c0a80002']; //游客访问
    public $homeRoot = [3=>'d423c27b-aed7-11ee-9216-0242c0a80002']; //登录用户
    public $adminRoot = [2=>'d423c1f1-aed7-11ee-9216-0242c0a80002']; //后台菜单*/

    public $openRoot = [4]; //游客访问
    public $homeRoot = [3]; //登录用户
    public $adminRoot = [2]; //后台菜单

    protected $itemName='菜单';
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
        'item_name',
        'is_out_link'
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
        ],
        'is_out_link'=>[
            'No',
            'Yes'
        ],
        'group'=>[
            "none" => "none",
            "open" => "open",
            "home" => "home",
            "admin" => "admin",
        ],
        'middleware'=>[
            "auth" => "auth",
            "auth.basic" => "auth.basic",
            "bindings" => "bindings",
            "cache.headers" => "cache.headers",
            "can" => "can",
            "guest" => "guest",
            "password.confirm" => "password.confirm",
            "signed" => "signed",
            "throttle" => "throttle",
            "verified" => "verified",
            "log" => "log",
            "api_client" => "api_client",
            "auth.redirect" => "auth.redirect",
            "admin" => "admin",
            "activated" => "activated",
            "member" => "member"
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
        'item_name'=>'',
        'is_out_link'=>0
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
        'is_out_link'=>'Whether it is an external page',
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
     * 接口路由参数
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function route_params(){
        return $this->hasMany('App\Models\Param')
            ->where('use',2);
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

    /**
     * 在模块以内
     * @param $q
     * @param $ids
     * @return mixed
     */
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
     * 在模块以外
     * @param $q
     * @param $ids
     * @return mixed
     */
    public function scopeNotModule($q,$ids){
        $str = $this->getConnection()->getDriverName()=='pgsql'?'"':'`';
        collect(Menu::whereIn('id',$ids)->get())
            ->map(function ($menu,$index)use(&$q,$str){
                $q->whereRaw(DB::Raw("({$str}left_margin{$str}>= {$menu['left_margin']} AND {$str}right_margin{$str}<= {$menu['right_margin']})=False"));
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
     * 通过访问路径直接判断是否拥有权限
     * @param $query
     * @param $path
     * @param string $method
     * @param bool $is_bool
     * @return bool|\Illuminate\Support\Collection
     */
    public function scopeHasPermissionPath($query,$path,$method='get',$is_bool=true){
        $route = app('routes')->match(\Illuminate\Support\Facades\Request::create($path));
        if($route){
            $url =Str::startsWith($route->uri,'/')?$route->uri:'/'.$route->uri;
            return self::isUrlInMenus($url,self::getMain(),$method,$is_bool);
        }else{
            return $is_bool?false:collect([]);
        }
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
            return $item['url']===$url && in_array($method,$item['method']);
            //return strpos($item['url'],$url)===0 && in_array($method,$item['method']);
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
        collect(['method','disabled','status','is_page','use','is_out_link'])->map(function ($key)use(&$item){
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
        if (($resource_id && !($resource_id==='0') && $resource_id!=-1)  && $res == $value && (str_contains($value, '{') || app('translator')->getLocale() != 'en')) { //没有翻译成功
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

    public static function toNumOrStrId($value){
        if($value==='0'){
            return 0;
        }
        return is_numeric($value)?$value-0:$value;
    }

/*    public function getResourceIdAttribute($value)
    {
        if($value==='0'){
            return 0;
        }
        return is_numeric($value)?$value-0:$value;
    }

    public function getParentIdAttribute($value)
    {
        if($value==='0'){
            return 0;
        }
        return is_numeric($value)?$value-0:$value;
    }

    public function getIdAttribute($value)
    {
        return is_numeric($value)?$value-0:$value;
    }*/


}
