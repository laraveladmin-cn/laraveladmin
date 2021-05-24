<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Feature;
use Illuminate\Support\Facades\Response;

class FeatureController extends Controller
{
    use ResourceController;
    protected $sizer=[
        'name'=>'like'
    ];

    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Feature';

    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule(){
        return [
            'name'=>'required|min:2|max:8',
            'color'=>'required',
            'description'=>'required|min:20|max:100',
            'icon'=>'nullable|alpha_dash'
        ];
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
