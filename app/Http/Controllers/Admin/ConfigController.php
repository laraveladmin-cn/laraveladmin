<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class ConfigController extends Controller
{
    use ResourceController;
    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Config';


    protected $sizer=[
        'name|key'=>'like'
    ];
    /**
     * Index页面字段名称显示
     * @var array
     */
    public $showIndexFields=[
        'id','name','description','key','value','updated_at'
    ];



    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule(){
        $id = Request::input('id',0);
        return [
            'name' => 'required',
            'key' => 'required|alpha_dash|unique:configs,key,'.$id.',id,deleted_at,NULL',
            'type'=>'required|in:1,2,3',
            'itype'=>'required|in:1,2,3'
        ];
    }

    protected function getImportValidateRule($id,$item){
        $validate = [
            'key' => 'required|alpha_dash|unique:configs,key,'.$id.',id,deleted_at,NULL',
        ];
        return $validate;
    }

    protected function handleIndexReturn(&$data){
        $data['configUrl']['importUrl'] = '';
        $data['configUrl']['createUrl'] = '';
        $data['configUrl']['deleteUrl'] = '';
        return $data;
    }

    /**
     * 编辑页面数据返回处理
     * @param $id
     * @param $data
     * @return mixed
     */
    protected function handleEditReturn($id,&$data){
        $data['configUrl']['importUrl'] = '';
        $data['configUrl']['createUrl'] = '';
        return $data;
    }

}
