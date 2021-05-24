<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Technology;
use Illuminate\Support\Facades\Response;

class TechnologyController extends Controller
{
    use ResourceController;

    protected $sizer=[
      'name'=>'like'
    ];

    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Technology';

    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule()
    {
        return ['name' => 'required|min:2|max:20', 'url' => 'nullable|url', 'logo' => 'required|url', 'description' => 'required|min:20|max:150'];
    }

    /**
     * 编辑页面数据返回处理
     * @param  $id
     * @param  $data
     * @return  mixed
     */
    protected function handleEditReturn($id, &$data)
    {
        return $data;
    }


}
