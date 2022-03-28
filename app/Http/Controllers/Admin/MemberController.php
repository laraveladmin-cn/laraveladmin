<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Response;

class MemberController extends Controller
{
    use ResourceController;

    /**
     * 筛选条件
     * @var array
     */
    protected $sizer = [
        'user.name|user.uname|user.mobile_phone'=>'like'
    ];

    /**
     * 默认排序
     * @var array
     */
    protected $orderDefault = [
        'left_margin'=>'asc'
    ];


    /**
     * Index页面字段名称显示
     * @var array
     */
    public $showIndexFields=[
        'user'=>['id','name','uname'],
        'parent'=>[
            'id','user_id',
            'user'=>['id','name']
        ]
    ];

    public $editFields=[
        'user'=>[],
        'parent'=>[
            'user'=>[]
        ]
    ];

    /**
     * 导出字段名称
     *
     * @var array
     */
    public $exportFieldsName = [
        'user.uname' => 'User name',
        'user.name' => 'Name',
        'parent.user.uname' => '推荐人用户名',
        'parent.user.name' => '推荐人',
        'user_id' => 'User ID',
        'parent_id' => '父级ID',
        'id' => 'ID'
    ];

    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Member';

    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule(){
        $id = Request::input('id',0);
        $validate = [
            'user_id'=>'integer|exists:users,id|unique:members,user_id,'.$id.',id,deleted_at,NULL',
            'parent_id'=>'sometimes|required|exists:members,id'
        ];
        if(!Member::where('id',1)->value('id')  || Request::input('id')==1){
            unset($validate['parent_id']);
        }
        return $validate;
    }

    /**
    * 编辑页面数据返回处理
    * @param  $id
    * @param  $data
    * @return  mixed
    */
    protected function handleEditReturn($id,&$data){
        $data['no_root'] = !Member::where('id',1)->value('id') || $id==1;
        $data['maps']['user_id'] = mapOption($data['row'],'user_id');
        $data['maps']['parent_id'] = mapOption($data['row'],'parent_id');
        return $data;
    }

    /**
     * 列表页面数据获取前对数据处理
     * @param $obj
     * @return mixed
     */
    protected function handleList(&$obj)
    {
        if($optional_parent = Request::input('optional_parent')){
            $obj = $obj->optionalParent($optional_parent ? Member::find($optional_parent) : null);
        }
        return $obj;
    }


}
