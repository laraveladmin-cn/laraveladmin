<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Area;
use Illuminate\Support\Facades\Response;

class AreaController extends Controller
{
    use ResourceController;



    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Area';

    //默认排序
    protected $orderDefault = [
        'left_margin'=>'asc'
    ];

    //条件筛选
    protected $sizer=[
        'parent_id'=>'=',
        'level'=>'=',
        'name'=>'like'
    ];

    /**
     * 编辑页面显示字段
     * @var array
     */
    public $editFields = [
        'parent' => ['name', 'id']
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
        'parent_id' => 'Parent ID',
        'id'=>'ID',
    ];

    /**
     * 获取条件拼接对象
     * @return mixed
     */
    protected function getWithOptionModel($fields_key = 'showIndexFields',$unset_order=false)
    {
        $this->bindModel OR $this->bindModel();
        $options = $this->getOptions(); //筛选项+排序项
        if($unset_order){
            unset($options['order']);
        }
        $obj = $this->bindModel->with($this->selectWithFields($fields_key))
            ->withCount(collect($this->getShowIndexFieldsCount())->filter(function ($item, $key) {
                return !is_array($item);
            })->toArray())
            ->options($options);
        if($optional_parent_id = intval(Request::input('optional_parent_id'))){
            $obj = $obj->optionalParent($optional_parent_id ? Area::find($optional_parent_id) : null);
        }
        return $obj;
    }

    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule(){
        $validate = [
            'name'=>'required',
            'parent_id'=>'sometimes|required|exists:areas,id'
        ];
        if(!Area::where('id',1)->value('id')  || Request::input('id')==1){
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
        $data['no_root'] = !Area::where('id',1)->value('id') || $id==1;
        return $data;
    }




}
