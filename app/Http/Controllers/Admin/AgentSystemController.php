<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

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


    /**
     * 列表页面返回数据前对数据处理
     * @param $data
     * @return mixed
     */
    protected function handleIndexReturn(&$data)
    {
        $conditionDeleteUrl = '/admin/agent-systems/condition-delete';
        $data['configUrl']['conditionDeleteUrl'] = Menu::hasPermission($conditionDeleteUrl, 'delete')?$conditionDeleteUrl:'';
        return $data;
    }

    /**
     * 指定筛选条件删除
     */
    public function conditionDelete()
    {
        $this->bindModel OR $this->bindModel();
        $options = $this->getOptions(); //筛选项+排序项
        $res = $this->bindModel()->options($options)->delete();
        if ($res === false) {
            return Response::returns(['alert' => alert(['message' => trans('The operation failure!')], 500)]);
        }
        return Response::returns(['alert' => alert(['message' => trans('The operation successful!')])]);
    }

}
