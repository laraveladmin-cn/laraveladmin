<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class YearController extends Controller
{
    use ResourceController;
    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Year';


    protected $sizer=[
        'name'=>'like'
    ];
    /**
     * Index页面字段名称显示
     * @var array
     */
    public $showIndexFields=[
        'id',
        'value',
        'name',
        'description',
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
            'name'=>'required|unique:years,name,'.$id.',id,deleted_at,NULL',
            'value'=>'required|integer|unique:years,value,'.$id.',id,deleted_at,NULL'
        ];
    }

    protected function getImportValidateRule($id,$item){
        $validate = [
            'name'=>'required',
            'value'=>'required|integer|unique:years,value,'.$id.',id,deleted_at,NULL'
        ];
        return $validate;
    }

}
