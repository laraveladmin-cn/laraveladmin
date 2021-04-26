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
            $this->bindModel = $this->newBindModel()->usable();
        }

        return $this->bindModel;
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

        'parent' => [
            'name',
            'id',
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

        'parent' => [
            'name',
            'id',
        ],
    ];

    //字段导出
    public $exportFieldsName = [
        'name' => '名称',
        'icons' => '图标',
        'description' => '描述',
        'url' => 'URL路径',
        'parent.name' => '父级名称',
        'method' => '请求方式',
        'is_page' => '是否为页面',
        'disabled' => '功能状态',
        'status' => '状态',
        'level' => '层级',
        'parent_id' => '父级ID',
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
            'icons' => 'nullable|alpha_dash',
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
        $data['maps']['optional_parents'] = Menu::optionalParent($id ? $data['row'] : null)
            ->usable()
            ->orderBy('left_margin', 'asc')
            ->get(['id', 'name', 'icons', 'parent_id', 'level', 'left_margin', 'right_margin']);
        $data['maps']['_type'] = [
            '普通链接',
            '资源',
            '单独路由',
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
            ->get(['id', 'name', 'icons', 'parent_id', 'level', 'left_margin', 'right_margin','item_name']))
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
}
