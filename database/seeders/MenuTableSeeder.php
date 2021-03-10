<?php
namespace Database\Seeders;
use App\Services\RouteService;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use \Illuminate\Support\Facades\Cache;
use \Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class MenuTableSeeder extends Seeder
{
    public function __construct()
    {
        $this->fillable = Menu::getFillables();
    }

    protected $del_ids = [];

    /**
     * ID+5
     * 创建资源菜单
     */
    public function createResourceMenu(Menu $roleMenu,$name='',array $options = []){
        if(!$this->methods){
            $this->methods = RouteService::getResourceRoutes(['except'=>['index']]);
        }
        //控制器默认路由注册
        $methods = collect($this->methods);
        $ids = [];
        $map_item = collect([]);
        if($options){
            $except = Arr::get($options,'except');
            $only = Arr::get($options,'only');
            if($except){
                if(is_array($except[0])){
                    $except = collect($except)->pluck('name');
                }
                $methods = $methods->except($except);
            }
            if($only){
                if(is_array($only[0])){
                    $map_item = collect($only)->keyBy('name');
                    $only = collect($only)->pluck('name');
                    $ids = collect($only)->pluck('id','name');
                    $this->del_ids = collect($this->del_ids)->merge(collect($only)->filter(function ($item){
                        return Arr::get($item,'_is_deleted');
                    })->pluck('id')
                        ->toArray())->toArray();
                }
                $methods = $methods->only($only);
            }
        }
        $add_id = $roleMenu['id'];
        $methods->each(function ($item,$key)use ($name,$roleMenu,$ids,&$add_id,$map_item){
            $item1 = $map_item->get($key,[]);
            $add_id = $add_id+1;
            $p_env = Arr::get($roleMenu,'env','');
            $env = Arr::get($item1,'env',$p_env);
            $p_disabled = Arr::get($roleMenu,'disabled',0);
            $disabled = Arr::get($item1,'disabled',$p_disabled);
            $data = [
                'method'=>Menu::methodValue(Arr::get($item,'method.type')),
                'parent_id'=>$roleMenu['id'],
                'url'=>$item['route']?$roleMenu['url'].'/'.$item['route']:$roleMenu['url'],
                'status'=>2, //不显示
                'disabled'=>$disabled,
                'resource_id'=>$roleMenu['id'],
                'item_name'=>'_'.$key,
                'env'=> $env
            ];
            if($id = Arr::get($ids,$key)){
                $data['id'] = $id;
            }else{
                $data['id'] = $add_id;
            }
            if($key=='list'){
                $data['name'] = $name.'分页';
                $data['icons'] = 'fa-list';
                $data['description'] = $name.'分页数据';
            }elseif($key=='show'){
                $data['name'] = '编辑查看'.$name;
                $data['icons'] = 'fa-edit';
                $data['description'] = $name.'编辑页面';
            }elseif($key=='create'){
                $data['name'] = '创建'.$name;
                $data['icons'] = 'fa-edit';
                $data['description'] = '提交创建'.$name.'请求';
            }elseif($key=='update'){
                $data['name'] = '更新'.$name;
                $data['icons'] = 'fa-edit';
                $data['description'] = '提交更新'.$name.'请求';
            }elseif($key=='destroy'){
                $data['name'] = '删除'.$name;
                $data['icons'] = 'fa-trash-o';
                $data['description'] =  '删除'.$name.'数据';
            }elseif($key=='export'){
                $data['name'] = '导出'.$name;
                $data['icons'] = 'fa-file-excel-o';
                $data['description'] = 'Excel导出'.$name.'数据';
            }elseif($key=='import'){
                $data['name'] = '导入'.$name;
                $data['icons'] = 'fa-database';
                $data['description'] = 'Excel导入'.$name.'数据';
            }else{
                $data['name'] = '删除'.$name;
                $data['icons'] = 'fa-trash-o';
                $data['description'] = '删除'.$name.'数据';
            }
            Menu::create($data);
        });
    }

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

    protected $cache_key = '_route_json_change';

    protected $methods = [];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->methods = RouteService::getResourceRoutes(['except'=>['index']]);
        $routes_json = file_get_contents(base_path('routes/route.json'));
        $disabled_menus = config('laravel_admin.disabled_menus','');
        $hash = md5(config('app.env').$routes_json.$disabled_menus);
        //判断菜单是否改变
        if($hash==Cache::get($this->cache_key, '') && config('app.env')!='local'){
            $this->command->line('菜单未改变!');
            return true;
        }
        //初始化数据表
        DB::table('menus')->truncate(); //菜单权限表
        Cache::put($this->cache_key, $hash);
        $routesConfig = json_decode($routes_json,true);
        collect(Arr::get($routesConfig,'menus',[]))
            ->merge(collect(Arr::get($routesConfig,'resource',[]))
                ->map(function ($item){
                    $item['is_resource'] = 1;
                    $item['resource_id'] = -1;
                    return $item;
                })
                ->toArray())
            ->map(function ($item){
                $item['_id'] = Arr::get($item,'_id',$item['id']);
                return $item;
            })
            ->sortBy('_id') //顺序创建
            ->map(function ($item)use (&$del_ids){
                $item = Menu::decodeValue($item);//兼容解码
                if(Arr::get($item,'is_resource')){
                    $menu = Menu::create(collect($item)->only($this->fillable)->toArray());
                    $name = Arr::get($item,'item_name',Arr::get($item,'name',''));
                    $options = Arr::get($item,'options',[]);
                    $this->createResourceMenu($menu,$name,$options);
                }else{
                    $menu = Menu::create(collect($item)->only($this->fillable)->toArray());
                }
                if(Arr::get($item,'_is_deleted')){
                    $this->del_ids = collect($this->del_ids)->push($menu['id'])->toArray();
                }
            });
        collect(Arr::get($routesConfig,'update_position',[]))->map(function ($item){
            if($item['type']=='update'){
                Menu::find($item['from'])->update(['parent_id'=>$item['to']]);
            }else{
                Menu::find($item['from'])->moveNear($item['to'],$item['type']);
            }
        });
        //禁用的菜单功能
        $menu_ids = explode(',',$disabled_menus)?:[];
        $menu_ids = collect(Menu::where('disabled',1)->pluck('id'))->merge($menu_ids)->unique()->toArray();
        if($menu_ids){
            Menu::where(function ($q)use($menu_ids){
                $q->where('id','=',0);
                Menu::whereIn('id',$menu_ids)->get()
                    ->map(function ($item)use(&$q){
                        $q->orWhere(function ($q)use($item){
                            $q->where('left_margin','>=',$item['left_margin'])
                                ->where('right_margin','<=',$item['right_margin']);
                        });
                    });
            })
                ->update(['disabled'=>1]);
        }
        if($this->del_ids){
            Menu::whereIn('id',$this->del_ids)->delete();
        }
        RouteService::upRouteJson();
    }




}
