<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\App;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Arr;

class AppController extends Controller
{
    use ResourceController;


    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'App';

    /**
     * 筛选条件
     * @var array
     */
    public $sizer = [
        'type'=>'=',
        'id'=>'>',
        'name|version'=>'like'
    ];

    public $orderDefault=[
        'id'=>'desc'
    ];

    public $showIndexFields=[
        'id',
        'type',
        'name',
        'version',
        'forced_update',
        'created_at',
        'updated_at',
        'operate_id',
        'operate'=>[
            'id',
            'name'
        ]
    ];

    /**
     * 验证规则
     * @return    array
     */
    protected function getValidateRule($id=0)
    {
        return $this->getImportValidateRule($id,Request::all());
    }

    /**
     * 验证规则
     * @return  array
     */
    protected function getImportValidateRule($id = 0, $item){
        $validate = [
            'type'=>'sometimes|in:0,1',
            'name'=>'required',
            'description'=>'required',
            'url'=>'required|url',
            'version'=>'required',
            'forced_update'=>'sometimes|in:0,1'
        ];
        return $validate;
    }

    /**
    * 编辑页面数据返回处理
    * @param  $id
    * @param  $data
    * @return  mixed
    */
    protected function handleEditReturn($id,&$data){
        return $data;
    }


}
