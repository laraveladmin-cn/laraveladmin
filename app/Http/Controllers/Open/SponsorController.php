<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;

class SponsorController extends Controller
{
    use ResourceController;

    /**
     * 默认每页取多少条
     * @var int
     */
    protected $per_page = 16;

    /**
     * 不需要权限检查
     * @var bool
     */
    protected $checkPermission = false;

    /**
     * 筛选条件
     * @var array
     */
    protected $sizer=[
        'name'=>'like'
    ];

    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Sponsor';

    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule()
    {
        $validate = [
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
        $data['configUrl']['exportUrl']='';
        $data['configUrl']['importUrl']='';
        $data['configUrl']['showUrl']='';
        $data['configUrl']['createUrl']='';
        $data['configUrl']['updateUrl']='';
        $data['configUrl']['deleteUrl']='';
        return $data;
    }


}
