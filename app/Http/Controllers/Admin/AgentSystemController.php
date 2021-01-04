<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class AgentSystemController extends Controller
{
    use ResourceController;
    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'AgentSystem';


    protected $sizer=[
        'name'=>'like'
    ];
    /**
     * Index页面字段名称显示
     * @var array
     */
    public $showIndexFields=[
        'id',
        'name',
        'full_name',
        'created_at',
        'updated_at'
    ];




    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule(){
        $id = Request::input('id',0);
        return [
            'name'=>'required',
            'full_name'=>'required|alpha|unique:banks,full_name,'.$id.',id,deleted_at,NULL',
        ];
    }

    protected function getImportValidateRule($id,$item){
        $validate = [
            'name'=>'sometimes|required',
            'full_name'=>'required|alpha|unique:banks,full_name,'.$id.',id,deleted_at,NULL',
        ];
        return $validate;
    }

}
