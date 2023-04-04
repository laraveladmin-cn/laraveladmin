<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;

class OuserController extends Controller
{
    use ResourceController;

    public $sizer=[
        'type'=>'=',
        'data|user.uname|user.name|user.mobile_phone'=>'like'
    ];


    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Ouser';

    /**
     * Index页面字段名称显示
     * @var array
     */
    public $showIndexFields=[
        'user'=>['id','name','uname']
    ];

    /**
     * 编辑页面显示字段
     * @var array
     */
    public $editFields = [
        'user'=>[
            'id','name','uname'
        ]
    ];



    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule(){
        $validate = [];
        return $validate;
    }

    /**
     * 编辑页面数据返回处理
     * @param  $id
     * @param  $data
     * @return  mixed
     */
    protected function handleEditReturn($id,&$data){
        $data['maps']['user_id'] = mapOption($data['row'],'user_id');
        return $data;
    }


}
