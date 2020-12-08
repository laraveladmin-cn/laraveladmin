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
    /**
     * ID+5
     * 创建资源菜单
     */
    protected function createRessorceMenu(Menu $roleMenu,$name='',array $options = []){
        //控制器默认路由注册
        $methods = collect($this->methods);
        if($options){
            $except = Arr::get($options,'except');
            $only = Arr::get($options,'only');
            $except AND $methods = $methods->except($except);
            $only AND $methods = $methods->only($only);
        }
        $methods->each(function ($item,$key)use ($name,$roleMenu){
            $data = [
                'method'=>Menu::methodValue(Arr::get($item,'method.type')),
                'parent_id'=>$roleMenu['id'],
                'url'=>$item['route']?$roleMenu['url'].'/'.$item['route']:$roleMenu['url'],
                'status'=>2
            ];
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
        $this->methods = RouteService::getRessorceRoutes(['except'=>['index']]);
        $routes_json = file_get_contents(base_path('routes/route.json'));
        $hash = md5($routes_json);
        //判断菜单是否改变
        if($hash==Cache::get($this->cache_key, '')){
            $this->command->line('菜单未改变!');
            return true;
        }
        Cache::put($this->cache_key, $hash);
        //初始化数据表
        DB::table('menus')->truncate(); //菜单权限表
        $routesConfig = json_decode($routes_json,true);
        collect(Arr::get($routesConfig,'menus',[]))
            ->merge(collect(Arr::get($routesConfig,'ressorce',[]))
                ->map(function ($item){
                    $item['is_ressorce'] = 1;
                    return $item;
                })
                ->toArray())
            ->sortBy('id')
            ->map(function ($item){
                if(Arr::get($item,'is_ressorce')){
                    $menu = Menu::create(collect($item)->only($this->fillable)->toArray());
                    $name = Arr::get($item,'item_name',Arr::get($item,'name',''));
                    $options = Arr::get($item,'options',[]);
                    $this->createRessorceMenu($menu,$name,$options);
                }else{
                    Menu::create(collect($item)->only($this->fillable)->toArray());
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
        $menu_ids = explode(',',config('laravel_admin.disabled_menus',''));
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
    }




}
