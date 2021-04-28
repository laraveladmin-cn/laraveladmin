<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    use ResourceController;

    /**
     * 资源模型
     *
     * @var  string
     */
    protected $resourceModel = 'Role';

    /**
     * 默认排序
     *
     * @var array
     */
    protected $orderDefault = [
        'left_margin' => 'asc',
        'id' => 'asc',
    ];

    /**
     * @var array
     */
    protected $sizer = [
        'roles.id' => '=',
        'is_tmp'=> '=',
        'name'=> 'like',
    ];

    /**
     * Index页面字段名称显示
     *
     * @var array
     */
    public $showIndexFields = [
        'id',
        'name',
        'description',
        'parent_id',
        'level',
        'updated_at',

        'parent' => [
            'id',
            'name',
        ],
    ];

    /**
     * Index页面字段名称显示多条数据统计值
     *
     * @var array
     */
    public $showIndexFieldsCount = [
        'admins',
    ];

    /**
     * 编辑页面时的字段值
     *
     * @var array
     */
    public $editFields = [
        'menus' => [
            'id',
        ],

        'tmp' => [
            'id',
            'name',
        ],
    ];



    /**
     * 验证规则
     *
     * @return  array
     */
    protected function getValidateRule()
    {
        $id = Request::input('id',0);

        $validate = [
            'name' => 'required',
            'parent_id' => 'sometimes|required|exists:roles,id',
            'menu_ids' => 'required|array',
        ];

        if ( $id == 1 ) {
            unset($validate['parent_id']);
        }

        return $validate;
    }

    /**
     * @param $id
     * @param $item
     * @return array
     */
    protected function getImportValidateRule($id, $item)
    {
        $validate = [];

        return $validate;
    }

    /**
     * 编辑页面数据返回处理
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    protected function handleEditReturn($id, &$data){
        //树状结构可选数据
        $data['maps']['optional_parents'] = collect(Role::optionalParent($id ? $data['row'] : null)
            ->orderBy('left_margin', 'asc')
            ->get(['id','name','parent_id','level','left_margin','right_margin']))
            ->map(function ($item){
                $item = collect($item)->toArray();
                $item[config('laravel_admin.trans_prefix').'name'] = trans_path($item['name'],'_shared.datas.roles.name');
                return $item;
        });
        //所有权限菜单
        $data['maps']['permissions'] = collect(Menu::mainAdmin()
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
        if ( $id == 1 ) {
            $data['menu_ids'] = collect($data['maps']['permissions'])->pluck('id')->toArray();
        }

        return $data;
    }

    /**
     * 执行修改或添加
     */
    public function postEdit(\Illuminate\Http\Request $request)
    {
        $validate = $this->getValidateRule();
        $validator = Validator::make($request->all(), $validate);
        if ( $validator->fails() ) {
            return Response::returns([
                'errors' => $validator->errors()->toArray(),
                'message' => trans('The given data was invalid.')
            ], 422);
        }
        $id = $request->get('id');
        $is_super = Role::isSuper();
        if ( $id && !$is_super && !in_array($id,Role::onlyChildren()->pluck('id')->toArray()) ) {
            return ['alert'=>alert([
                'message'=>trans('You have no right to modify this role!')//'你无权修改该角色!'
            ],422)];
        }
        //添加或修改角色父ID权限判断
        if ( ! $is_super ) {
            $parent_id = $request->get('parent_id');
            if ( !$parent_id || !in_array($parent_id,Role::main()->pluck('id')->toArray()) ) {
                return ['alert'=>alert([
                    'message'=>trans('Set the parent role to be only the group of roles that you have permissions on!')//'设置父级角色只能是你有权限的角色分组!'
                ],422)];
            }
        }
        //当前用户拥有的权限
        $have = Menu::main()->admin()->pluck('id')->toArray();
        //新角色权限
        $new_permissions = collect($request->get('menu_ids'))->intersect($have)->all();
        $this->bindModel OR $this->bindModel(); //绑定模型
        $data = $id ? $request->all() : $request->except('id');
        $data['operate_id'] = User::getOperateId();
        unset($data['menu_ids']);
        //处理修改时日期字段
        $data = $this->handDateFields($data, $this->importExcelDateFields);
        if ( $id ) {
            $item = $this->bindModel->find($id);
            $res = $item->update($data);
            if ( $res === false ) {
                return Response::returns(['alert' => alert(['message' => trans('Modify the failure!')], 500)]);
            }
            //修改菜单-角色关系
            if ( $id != 1 ) {
                //当前用户拥有该角色的旧权限
                $old_permissions = $item->menus->pluck('id')
                    ->intersect($have)
                    ->all();
                //删除旧的权限,添加新权限
                $add_permissions = collect($new_permissions)->diff($old_permissions)->all();
                $del_permissions = collect($old_permissions)->diff($new_permissions)->all();

                $del_permissions AND $item->menus()->detach($del_permissions);
                $add_permissions AND MenuRole::insertReplaceAll(collect($add_permissions)->map(function($value)use($item){
                    return ['role_id'=>$item['id'],'menu_id'=>$value];
                })->toArray());


                //如果是模板,修改子集
                if ( $data['is_tmp'] ) {
                    Role::where('tmp_id','=',$id)->get()->map(function($item)use($add_permissions,$del_permissions){
                        $del_permissions AND $item->menus()->detach($del_permissions);
                        $add_permissions AND MenuRole::insertReplaceAll(collect($add_permissions)->map(function($value)use($item){
                            return ['role_id'=>$item['id'],'menu_id'=>$value];
                        })->toArray());
                    });
                }
                //新增权限父节点都将拥有
                Role::parents($item,true)->get()->each(function($item) use($add_permissions){
                    $add_permissions AND MenuRole::insertReplaceAll(collect($add_permissions)->map(function($value)use($item){
                        return ['role_id'=>$item['id'],'menu_id'=>$value];
                    })->toArray());
                });
                //删除节点权限子节点都删除
                Role::children($item)->get()->each(function($item) use($del_permissions){
                    $del_permissions AND $item->menus()->detach($del_permissions);
                });

            }
            $this->saveRelation($item,$data);
            $this->handlePostEdit($item,$data);

            return Response::returns(['alert' => alert(['message' => trans('Modify the success!')])]);
        }
        $data['updated_at'] = date('Y-m-d H:i:s');
        //新增
        $item = $this->bindModel->create($data);
        if ( $item === false ) {
            return Response::returns(['alert' => alert(['message' => trans('Create a failure!')], 500)]);
        }
        //所有父节点添加对应权限
        Role::parents($item, true)->each(function ($item) use ($new_permissions) {
            $new_permissions AND MenuRole::insertReplaceAll(collect($new_permissions)->map(function($value)use($item){
                return ['role_id'=>$item['id'],'menu_id'=>$value];
            })->toArray());
        });
        $this->saveRelation($item,$data);
        $this->handlePostEdit($item,$data);

        return Response::returns(['alert' => alert(['message' => trans('Create a successful!')])]);
    }

    protected function handleDestroyReturn(&$data)
    {
        $data = collect($data)->filter(function ($id) {
            return $id>1;
        })->toArray();

        return $data;
    }
}
