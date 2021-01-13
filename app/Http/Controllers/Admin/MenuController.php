<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ResourceController;
use App\Models\Menu;

class MenuController extends Controller
{
    use ResourceController;

    /**
     * 绑定模型
     * @return mixed
     */
    protected function bindModel()
    {
        if (!$this->bindModel) {
            $this->bindModel = $this->newBindModel()->usable();
        }
        return $this->bindModel;
    }
    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Menu';

    protected $orderDefault=[
        'left_margin'=>'asc',
        'id'=>'asc'
    ];

    protected $sizer = [
        'status' => '=',
        'is_page' => '=',
        'method' => '&',
        'name' => 'like',
        'name|url' => 'like',
    ];

    /**
     * Index页面字段名称显示
     * @var array
     */
    public $showIndexFields = [
        'id',
        'icons',
        'name',
        'url',
        'parent_id',
        'level',
        'method',
        'is_page',
        'status',
        'created_at',
        'updated_at',
        'parent' => ['name', 'id']
    ];

    /**
     * excel导出数据字段
     * @var array
     */
    public $exportFields = [
        'id',
        'icons',
        'name',
        'url',
        'parent_id',
        'level',
        'method',
        'is_page',
        'status',
        'created_at',
        'updated_at',
        'parent' => ['name', 'id']
    ];

    //字段导出
    public $exportFieldsName = [
        'name' => '名称',
        'icons' => '图标',
        'description' => '描述',
        'url' => 'URL路径',
        'parent.name' => '父级名称',
        'method' => '请求方式',
        'is_page' => '是否为页面',
        'disabled' => '功能状态',
        'status' => '状态',
        'level' => '层级',
        'parent_id' => '父级ID',
        'id' => 'ID',
    ];

    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule()
    {
        return [
            'name' => 'required',
            'icons' => 'nullable|alpha_dash',
            'parent_id' => 'sometimes|required|exists:menus,id',
            'method' => 'required|array',
            'is_page' => 'in:0,1',
            'status' => 'in:1,2'
        ];
    }

    /**
     * 编辑页面数据返回处理
     * @param $id
     * @param $data
     * @return mixed
     */
    protected function handleEditReturn($id,&$data){
        //树状结构可选数据
        $data['maps']['optional_parents'] = Menu::optionalParent($id ? $data['row'] : null)
            ->usable()
            ->orderBy('left_margin', 'asc')
            ->get(['id','name','icons','parent_id','level','left_margin','right_margin']);
        $data['configUrl']['importUrl'] = '';
        $data['configUrl']['createUrl'] = '';
        $data['configUrl']['updateUrl'] = '';
        $data['configUrl']['deleteUrl'] = '';
        return $data;
    }

    protected function handleIndexReturn(&$data){
        $data['configUrl']['importUrl'] = '';
        $data['configUrl']['createUrl'] = '';
        $data['configUrl']['updateUrl'] = '';
        $data['configUrl']['deleteUrl'] = '';
        return $data;
    }





}
