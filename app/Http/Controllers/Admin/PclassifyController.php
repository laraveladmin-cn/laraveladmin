<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Pclassify;

class PclassifyController extends Controller
{
    use ResourceController;
    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Pclassify';

    //默认排序
    protected $orderDefault = [
        'left_margin'=>'asc',
        'id'=>'asc'
    ];

    //条件筛选
    protected $sizer=[
        'name'=>'like'
    ];

    /**
     * Index页面字段名称显示
     * @var array
     */
    public $showIndexFields = [
        'parent' => ['name', 'id']
    ];

    /**
     * excel导出数据查询字段
     * @var array
     */
    public $exportFields = [
        'parent' => ['name', 'id']
    ];

    //字段导出
    public $exportFieldsName = [
        'name' => 'Name',
        'parent.name' => 'Parent name',
        'description' => 'Remarks',
        'parent_id' => 'Parent ID',
        'id'=>'ID',
    ];


    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule(){
        return ['name'=>'required','parent_id'=>'sometimes|required|exists:classifys,id'];
    }

    /**
     * 编辑页面数据返回处理
     * @param $id
     * @param $data
     * @return mixed
     */
    protected function handleEditReturn($id,&$data){
        //树状结构可选数据
        $data['maps']['optional_parents'] = Pclassify::optionalParent($id ? $data['row'] : null)
            ->orderBy('left_margin', 'asc')
            ->get(['id','name','parent_id','level','left_margin','right_margin']);
        return $data;
    }


}
