<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\AdminRole;
use App\Models\Menu;
use App\Models\MenuRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    use ResourceController;

    /**
     * 资源模型
     *
     * @var  string
     */
    protected $resourceModel = 'Admin';

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
     * 筛选条件设置
     *
     * @var array
     */
    protected $sizer = [
        'roles.id' => '=',
        'user.name|user.uname' => 'like',
        'roles.name' => 'like',
    ];

    /**
     * 其它筛选条件输出
     *
     * @var array
     */
    protected $otherSizerOutput = [
        '_key' => 'user.name|user.uname'
    ];

    /**
     * 关键字搜索组
     *
     * @var array
     */
    protected $keywordsMap = [
        'user.name|user.uname' => 'User name',
        'roles.name' => 'Role Name',
    ];

    /**
     * Index页面字段名称显示
     *
     * @var array
     */
    public $showIndexFields = [
        'id',
        'user_id',
        'updated_at',

        'user'=>[
            'id',
            'uname',
            'name',
            'mobile_phone',
            'status',
        ],

        'roles' => [
            'id',
            'name',
        ],
    ];

    /**
     * 编辑页面查询字段
     *
     * @var array
     */
    public $editFields = [
        'user'=>[],

        'roles'=>[
            'id',
            'name',
        ],
    ];
    /**
     * excel导出数据查询字段
     * @var array
     */
    public $exportFields = [
        'user' => [],
    ];

    /**
     * 导出字段名称
     *
     * @var array
     */
    public $exportFieldsName = [
        'user.uname' => 'User name',
        'user.name' => 'Name',
        'user.avatar' => 'Head portrait',
        'user.email' => 'E-mail',
        'user.mobile_phone' => 'Phone number',
        'user.status' => 'State',
        'user.description' => 'Remarks',
        //'created_at' => 'Created At',
        //'updated_at' => 'Updated At',
        //'deleted_at' => 'Deleted At',
        'user_id' => 'User ID',
        'id' => 'ID'
    ];




    /**
     * 验证规则
     *
     * @return  array
     */
    protected function getValidateRule()
    {
        $id = Request::input('id',0);
        $user_id = Request::input('user_id',0);
        //没有密码值不对密码进行修改
        if ( ! Request::input('user.password') ) {
            $user = Request::input('user');
            unset($user['password']);
            Request::offsetSet('user', $user);
        }
        if ( ! Request::input('user_id') ) {
            Request::offsetUnset('user_id');
        }
        $validate = [
            'user_id' => 'sometimes|exists:users,id|unique:admins,user_id,' . $id . ',id,deleted_at,NULL',
            'user.uname' => 'sometimes|required|alpha_dash|between:6,18|unique:users,uname,' . $user_id . ',id,deleted_at,NULL',
            'user.password' => ($user_id ? 'sometimes|' : '').'required|between:6,18',
            'user.name' => 'required',
            'user.email' => 'nullable|email|unique:users,email,' . $user_id . ',id,deleted_at,NULL',
            'user.mobile_phone' => 'nullable|mobile_phone',
            'user.status' => 'nullable|in:0,1,2',
            'role_ids'=>'required|array'
        ];
        if ( $user_id ) {
            unset($validate['user.uname']);
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
     * @param $data
     * @param $obj
     * @return array
     */
    protected function handleListReturn(&$data, $obj)
    {
        $data = collect($data)->toArray();
        $data['data'] = collect($data['data'])->map(function($item){
            $item['roles_name'] = collect($item['roles'])->pluck('name')->implode(',');
            return $item;
        })->toArray();

        return $data;
    }

    /**
     * 执行修改前对数据进行处理
     * @param $data
     * @return mixed
     */
    protected function handlePostEditReturn(&$data)
    {
        //验证勾选角色
        $has_roles_id = Role::main('')->pluck('id')?:[];
        $role_ids = collect(Arr::get($data,'role_ids',[]))->unique();
        if(collect($has_roles_id)->intersect($role_ids->toArray())->count()!=$role_ids->count()){
            throw ValidationException::withMessages(['role_ids'=>[
                trans('You have no right to modify this role!')//'你无权修改该角色!'
            ]]);
        }

        if ( Arr::get($data,'user.id') == 1 ) {
            unset($data['user']['status']);
        }
        //创建或修改用户
        $user = Arr::get($data,'user', []);
        $user = User::updateOrCreate([
            'id' => $user['id'],
        ], $user);
        $data['user_id'] = $user['id'];
        unset($data['role_ids']);
        return $data;
    }

    /**
     * 保存数据后对返回数据处理
     * @param $item
     * @param $data
     */
    protected function handlePostEdit($item, $data)
    {
        //当前用户管理的角色
        $have = Role::main('')->pluck('id')->toArray();
        //新角色权限
        $new_roles = collect(Request::input('role_ids',[]))->intersect($have)->all();
        $id = Arr::get($data,'id',0);
        if($id){
            //修改菜单-角色关系
            if ( $id != 1 ) {
                //当前用户拥有该角色的旧权限
                $old_roles = $item->roles->pluck('id')
                    ->intersect($have)
                    ->all();
                //删除旧的权限,添加新权限
                $add_roles = collect($new_roles)->diff($old_roles)->all();
                $del_roles = collect($old_roles)->diff($new_roles)->all();
                $del_roles AND $item->roles()->detach($del_roles);
                $add_roles AND AdminRole::insertReplaceAll(collect($add_roles)->map(function($value)use($item){
                    return ['admin_id'=>$item['id'],'role_id'=>$value];
                })->toArray());
            }
        }else{
            //所有父节点添加对应权限
            $new_roles AND AdminRole::insertReplaceAll(collect($new_roles)->map(function($value)use($item){
                return ['admin_id'=>$item['id'],'role_id'=>$value];
            })->toArray());
        }
    }

    /**
     * @param $data
     * @return array
     */
    protected function handleDestroyReturn(&$data)
    {
        $data = collect($data)->filter(function ($id){
            return $id > 1;
        })->toArray();

        return $data;
    }
    /**
     * 编辑页面返回数据前对数据处理
     * @param $data
     * @return mixed
     */
    protected function handleEditReturn($id, &$data){
        $data['maps']['roles'] = $this->getRoles($id);
        $data['row'] = collect($data['row'])->toArray();
        $data['row']['bind_user'] = !!$data['row']['user_id'] - 0;
        $data['row']['user_id_back'] = $data['row']['user_id'];
        return $data;
    }

    /**
     * 获取用户角色
     * @param $id
     * @return mixed
     */
    protected function getRoles($id)
    {
        if ( $id ) {
            $admin = $this->newBindModel()->find($id);
            $has_roles = isset($admin->roles) ? $admin->roles : collect([]);
        } else {
            $has_roles = collect([]);
        }
        //我拥有的最高角色权限
        $my_roles = collect(Role::my()->get(['id','name','parent_id','level','left_margin','right_margin']));
        //获取当前用户所有下属角色
        $self_roles = $this->rolesChildsId(Role::isSuper());
        //列出所有角色,当前用户不可操作的角色禁用
        return Role::orderBy('left_margin')
            //过滤与其无关的角色
            ->where(function ($q)use($my_roles){
                $q->whereRaw('false');
                $my_roles->each(function ($role)use ($q){
                    $q->orWhere(function ($q)use ($role){
                        $q->whereRaw('(left_margin>='.$role['left_margin'].' && right_margin<='.$role['right_margin'].') or (left_margin<='.$role['left_margin'].' && right_margin>='.$role['right_margin'].')');
                    });
                });
            })
            ->get(['id','name','parent_id','level','left_margin','right_margin'])
            ->each(function ($item) use ($self_roles, $has_roles) {
                $item->checked = in_array($item->id, $has_roles->pluck('id')->toArray()); //当前用户拥有角色
                $item->disabled = $item->_disabled= !in_array($item->id, $self_roles); //添加用户角色是否可用
                $item->chkDisabled = $item->disabled;
            });
    }

    /**
     * 获取当前用户角色的子角色
     * @return array
     */
    protected function rolesChildsId($all = false, $id = true)
    {
        if ( $all ) {
            $res =  Role::main()->get();
        } else {
            $res = Role::OnlyChildren()->get();
        }

        return $id ? $res->pluck('id')->toArray() : $res->toArray();
    }

}
