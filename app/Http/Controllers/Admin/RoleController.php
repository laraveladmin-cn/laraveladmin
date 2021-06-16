<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
     * 绑定模型
     *
     * @return mixed
     */
    protected function bindModel()
    {
        if ( ! $this->bindModel ) {
            $this->bindModel = $this->newBindModel()->main('');
        }

        return $this->bindModel;
    }

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
        //我拥有的最高角色权限
        $my_roles = collect(Role::my()->get(['id','name','parent_id','level','left_margin','right_margin']));
        //树状结构可选数据
        $data['maps']['optional_parents'] = collect(Role::optionalParent($id ? $data['row'] : null)
            //过滤与其无关的角色
            ->where(function ($q)use($my_roles){
                $q->whereRaw('false');
                $my_roles->each(function ($role)use ($q){
                    $q->orWhere(function ($q)use ($role){
                        $q->whereRaw('(left_margin>='.$role['left_margin'].' && right_margin<='.$role['right_margin'].') or (left_margin<='.$role['left_margin'].' && right_margin>='.$role['right_margin'].')');
                    });
                });
            })
            ->orderBy('left_margin', 'asc')
            ->get(['id','name','parent_id','level','left_margin','right_margin']))
            ->map(function ($item)use($my_roles){
                $item = collect($item)->toArray();
                $item[config('laravel_admin.trans_prefix').'name'] = trans_path($item['name'],'_shared.datas.roles.name');
                //创建角色只能在我拥有的权限角色内选择
                $item['_disabled'] = !($my_roles->filter(function ($role)use ($item){
                    return $role['left_margin']<=$item['left_margin'] && $role['right_margin']>=$item['right_margin'];
                })->count()>0);
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
     * 执行修改前对数据进行处理
     * @param $data
     * @return mixed
     */
    protected function handlePostEditReturn(&$data)
    {
        $id = Arr::get($data,'id',0);
        $is_super = Role::isSuper();
        if ( $id && !$is_super && !in_array($id,Role::onlyChildren()->pluck('id')->toArray()) ) {
            throw ValidationException::withMessages(['id'=>[
                trans('You have no right to modify this role!')//'你无权修改该角色!'
            ]]);
        }
        //添加或修改角色父ID权限判断
        if ( ! $is_super ) {
            $parent_id = Arr::get($data,'parent_id',0);
            if ( !$parent_id || !in_array($parent_id,Role::main()->pluck('id')->toArray()) ) {
                throw ValidationException::withMessages(['parent_id'=>[
                    trans('Set the parent role to be only the group of roles that you have permissions on!')//'设置父级角色只能是你有权限的角色分组!'
                ]]);
            }
        }
        unset($data['menu_ids']);
        return $data;
    }

    /**
     * 保存数据后对返回数据处理
     * @param $item
     * @param $data
     */
    protected function handlePostEdit($item, $data)
    {
        //当前用户拥有的权限
        $have = Menu::mainAdmin()->pluck('id')->toArray();
        //新角色权限
        $new_permissions = collect(Request::input('menu_ids',[]))->intersect($have)->all();
        $id = Arr::get($data,'id',0);
        if($id){
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
        }else{
            //所有父节点添加对应权限
            Role::parents($item, true)->each(function ($item) use ($new_permissions) {
                $new_permissions AND MenuRole::insertReplaceAll(collect($new_permissions)->map(function($value)use($item){
                    return ['role_id'=>$item['id'],'menu_id'=>$value];
                })->toArray());
            });
        }

    }

    /**
     * 执行删除数据前对数据进行处理
     * @param $data
     * @return mixed
     */
    protected function handleDestroyReturn(&$data)
    {
        $data = collect($data)->filter(function ($id) {
            return $id>1;
        })->toArray();

        return $data;
    }
}
