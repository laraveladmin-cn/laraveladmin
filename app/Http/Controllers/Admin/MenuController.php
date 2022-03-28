<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ResourceController;
use App\Models\Menu;
use App\Services\RouteService;
use Database\Seeders\MenuTableSeeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    use ResourceController;

    /**
     * 绑定模型
     *
     * @return mixed
     */
    protected function bindModel()
    {
        if ( ! $this->bindModel ) {
            $this->bindModel = $this->newBindModel()->main();
        }

        return $this->bindModel;
    }

    /**
     * 获取条件拼接对象
     * @return mixed
     */
    protected function getWithOptionModel($fields_key = 'showIndexFields',$unset_order=false)
    {
        $this->bindModel OR $this->bindModel();
        $options = $this->getOptions(); //筛选项+排序项
        if($unset_order){
            unset($options['order']);
        }
        $where = collect($options['where'])->filter(function ($item){
            return in_array($item['key'],['name','name|url']) && $item['val'];
        })->toArray();
        $options['where'] = collect($options['where'])->filter(function ($item){
            return !in_array($item['key'],['name','name|url']);
        })->toArray();
        $obj = $this->bindModel->with($this->selectWithFields($fields_key))
            ->withCount(collect($this->getShowIndexFieldsCount())->filter(function ($item, $key) {
                return !is_array($item);
            })->toArray())
            ->options($options);
        $trans_name = config('laravel_admin.trans_prefix').'name';
        if($where){
            $menus_trans = collect(Menu::main()
                ->with(['parent'=>function($q){
                    $q->select([
                        'id',
                        'name',
                        'item_name'
                    ]);
                }])->get(['id', 'name', 'parent_id','resource_id']))->map(function ($item)use($trans_name){
                $item1 = collect($item)->toArray();
                $item1[$trans_name] = Menu::trans($item,'name');//trans_path($item['name'],'_shared.menus');
                return $item1;
            });
        }else{
            $menus_trans = [];
        }
        collect($where)->map(function ($item)use(&$obj,$menus_trans,$trans_name){
            $obj = $obj->where(function ($q)use($item,$menus_trans,$trans_name){
                $value = $item['val'];
                $menus_ids = collect($menus_trans)->filter(function ($item)use($value,$trans_name){
                    return Str::contains(Arr::get($item,$trans_name),$value);
                })->pluck('id')
                    ->toArray();
                $value = preg_replace('/([_%\'"])/','\\\$1',$value ).'%';
                if($item['key']=='name'){
                    $q->where($item['key'],$item['exp'],$value)
                        ->orWhere($item['key'],$item['exp'],'%'.$value);
                }elseif($item['key']=='name|url'){
                    $q->where('name',$item['exp'],$value)
                        ->orWhere('name',$item['exp'],'%'.$value)
                        ->orWhere('url',$item['exp'],$value)
                        ->orWhere('url',$item['exp'],'%'.$value);
                }
                $menus_ids and $q->orWhereIn('id',$menus_ids);
            });
        });

        return $obj;
    }

    /**
     * 资源模型
     *
     * @var  string
     */
    protected $resourceModel = 'Menu';

    protected $orderDefault = [
        'left_margin' => 'asc',
        'id' => 'asc',
    ];

    protected $sizer = [
        'status' => '=',
        'is_page' => '=',
        'method' => '&',
        'name' => 'like',
        'name|url' => 'like',
        'resource_id' => '=',
    ];

    /**
     * Index页面字段名称显示
     *
     * @var array
     */
    public $showIndexFields = [
        'id',
        'icons',
        'name',
        'url',
        'parent_id',
        'level',
        'method',
        'is_page',
        'status',
        'created_at',
        'updated_at',
        'resource_id',
        'parent' => [
            'id',
            'name',
            'item_name'
        ],
    ];

    /**
     * excel导出数据字段
     * @var array
     */
    public $exportFields = [
        'id',
        'icons',
        'name',
        'url',
        'parent_id',
        'level',
        'method',
        'is_page',
        'status',
        'created_at',
        'updated_at',
        'resource_id',
        'parent' => [
            'name',
            'id',
            'item_name'
        ],
    ];

    //字段导出
    public $exportFieldsName = [
        'name' => 'Name',
        'icons' => 'Icon',
        'description' => 'Describe',
        'url' => 'URL path',
        'parent.name' => 'Parent name',
        'method' => 'Request method',
        'is_page' => 'Is it a page',
        'disabled' => 'Functional status',
        'status' => 'State',
        'level' => 'Hierarchy',
        'parent_id' => 'Parent ID',
        'id' => 'ID',
    ];

    public $editFields = [
        'resource' => [
            'id',
            'name',
        ],

        'resources' => [
            'id',
            'name',
            'resource_id',
            'item_name',
        ]
    ];

    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule()
    {
        $_type = Request::input('_type',0);
        $validate = [
            'name' => 'required',
            'icons' => 'nullable|alpha_dash_space',
            'parent_id' => 'sometimes|required|exists:menus,id,deleted_at,NULL',
            'is_page' => 'in:0,1',
            'status' => 'in:1,2',
        ];
        if ( $_type ) {
            $validate['url'] = 'required|url_path';
            $validate['method'] = 'required|array';
            if ( !Str::is('_*', Request::input('item_name')) ) {
                $validate['group'] = 'required';
            }
        }

        return $validate;
    }

    /**
     * 编辑页面数据返回处理
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    protected function handleEditReturn($id, &$data)
    {
        $resource_id = Arr::get($data, 'row.resource_id', 0);
        $data['row']['_type'] = 0;
        $data['row']['_options'] = []; //资源
        $data['maps']['_options_name'] = [];
        if ( $resource_id == -1) {
            $data['row']['_type'] = 1;
            $data['row']['_options'] = collect(Arr::get($data,'row.resources',[]))->pluck('item_name')->toArray();
            $data['maps']['_options_name'] = collect(Arr::get($data,'row.resources',[]))->pluck('name','item_name')->toArray();
        } else if ( $data['row']['id'] && $data['row']['method'] ) {
            $data['row']['_type'] = 2;
        } else {
            $data['row']['method'] = [];
        }
        //树状结构可选数据
        $data['maps']['optional_parents'] = collect(Menu::optionalParent($id ? $data['row'] : null)
            ->usable()
            ->orderBy('left_margin', 'asc')
            ->with(['parent'=>function($q){
                $q->select([
                    'id',
                    'name',
                    'item_name'
                ]);
            }])
            ->get(['id', 'name', 'icons', 'parent_id', 'level', 'left_margin', 'right_margin','resource_id']))
            ->map(function ($item){
                $item = collect($item)->toArray();
                $item[config('laravel_admin.trans_prefix').'name'] = Menu::trans($item,'name');//trans_path($item['name'],'_shared.menus');
                return $item;
            });
        $data['maps']['_type'] = [
            'Common links',
            'Resources',
            'Single route',
        ];
        $data['maps']['_options']=collect(RouteService::getResourceRoutes(['except'=>['index']]))
            ->keys()
            ->map(function ($val){
                return '_'.$val;
            })
            ->toArray();

        return $data;
    }

    /**
     * 保存数据后对返回数据处理
     *
     * @param $item
     * @param $data
     */
    public function handlePostEdit($item, $data)
    {
        $id = Arr::get($item,'id',0)?:0;
        if(isset($data['_options'])){
            if($data['resource_id']==-1){ //资源
                if($id){
                    Menu::withTrashed()->where('resource_id',$id)->restore(); //恢复已删除
                    Menu::where('resource_id',$id)->whereNotIn('item_name',Arr::get($data,'_options',[]))->delete(); //去掉没有的
                }
                $_options = Menu::where('resource_id',$id)->where('id','>',0)->pluck('item_name')->toArray();
                $only = collect($data['_options'])->diff($_options)->map(function ($val){
                    return str_replace('_','',$val);
                })->values()->toArray();
                $name = Arr::get($item,'item_name')?:Arr::get($item,'name','');
                $options = $only?['only'=>$only]:[];
                $only and (new MenuTableSeeder)->createResourceMenu($item,$name,$options);
            }else{
                $id and Menu::where('resource_id',$id)->delete();
            }
        }
        //更新路由数据
        RouteService::upRouteJson();
    }


    /**
     * 拖拽位置页面数据准备
     *
     * @return mixed
     */
    public function tree()
    {
       $data['tree'] =  collect(Menu::optionalParent(null)
            ->usable()
            ->orderBy('left_margin', 'asc')
           ->with(['parent'=>function($q){
               $q->select([
                   'id',
                   'name',
                   'item_name'
               ]);
           }])
            ->get(['id', 'name', 'icons', 'parent_id', 'level', 'left_margin', 'right_margin','item_name','resource_id']))
           ->map(function ($item){
               $item = collect($item)->toArray();
               if( Str::is('_*', $item['item_name']) || $item['level'] <= 1 ){
                   $item['drag'] = false;
               }
               $item['_parent_id'] = $item['parent_id'];
               $item['_level'] = $item['level'];

               return $item;
           });
       $data['row']['update_position'] = [];
       $createUrl = '/admin/menus/update-position';
       $data['configUrl']['createUrl'] = Menu::hasPermission($createUrl,'post') ? $createUrl : '';

       return Response::returns($data);
    }

    /**
     * 布局位置修改
     * @return mixed
     */
    public function updatePosition()
    {
        collect(Request::input('update_position',[]))->map(function ($item){
            if( $item['type'] == 'update' ) {
                Menu::find($item['from'])->update(['parent_id'=>$item['to']]);
            } else {
                Menu::find($item['from'])->moveNear($item['to'],$item['type']);
            }
        });
        //更新路由数据
        RouteService::upRouteJson();

        return Response::returns(['alert' => alert(['message' => trans('Modify the success!')])]);
    }

    /**
     * 列表页面返回数据前对数据处理
     * @param $data
     * @return mixed
     */
    protected function handleListReturn(&$data, $obj)
    {
        $data = collect($data)->toArray();
        $data['data'] = collect($data['data'])->map(function ($item){
            $item[config('laravel_admin.trans_prefix').'name'] = Menu::trans($item,'name');//trans_path($item['name'],'_shared.menus');
            return $item;
        })->toArray();
        return $data;
    }
}
