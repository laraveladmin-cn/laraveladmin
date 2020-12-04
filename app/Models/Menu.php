<?php
/**
 * 菜单模型
 */
namespace App\Models;
use App\Facades\LifeData;
use App\Models\Traits\ExcludeTop;
use App\Models\Traits\TreeModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\BaseModel;
use Illuminate\Support\Str;

class Menu extends Model
{
    protected $table = 'menus'; //数据表名称
    //软删除,树状结构
    use SoftDeletes,TreeModel,ExcludeTop,BaseModel;
    protected $openRoot = [4]; //游客访问
    protected $homeRoot = [3]; //登录用户
    protected $adminRoot = [2]; //后台菜单
    //批量赋值白名单
    protected $fillable = [
        'name',
        'disabled',
        'icons',
        'description',
        'url',
        'parent_id',
        'method',
        'is_page',
        'status'
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
            '否',
            '是'
        ],
        'status'=>[
            1=>'显示',
            2=>'不显示'
        ],
        'disabled'=>[
            0=>'启用',
            1=>'禁用'
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
        'level'=>0,
        'left_margin'=>0,
        'right_margin'=>0,
        'disabled'=>0
    ];

    //字段默认值
    protected $fieldsName = [
        'name' => '名称',
        'icons' => '图标',
        'description' => '描述',
        'url' => 'URL路径',
        'parent_id' => '父级ID',
        'method' => '请求方式',
        'is_page' => '是否为页面',
        'disabled' => '功能状态',
        'status' => '状态',
        'level' => '层级',
        //'left_margin' => '左边界',
        //'right_margin' => '右边界',
        //'created_at' => '创建时间',
        //'updated_at' => '修改时间',
        //'deleted_at' => '删除时间',
        'id' => 'ID',
    ];

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
     * 接口参数
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function params(){
        return $this->hasMany('App\Models\Param');
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
        $query->where('disabled','=',0);
    }

    public function menu_roles(){
        return $this->hasMany('App\Models\MenuRole');
    }

    /**
     * 请求方式对应数据值
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
        $menu = [];
        collect($menus)->each(function($item) use (&$isIn,$url,$method,&$menu){
            if(strpos($item['url'],$url)===0 && in_array($method,$item['method'])){
                $isIn = true;
                $menu = $item;
            }
        });
        return $is_bool?$isIn:$menu;
    }



}
