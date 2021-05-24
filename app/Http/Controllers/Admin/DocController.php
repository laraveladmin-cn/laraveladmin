<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Doc;
use Illuminate\Support\Facades\Response;

class DocController extends Controller
{
    use ResourceController;

    protected $sizer=[
        'name|description'=>'like'
    ];

    /**
     * Index页面字段名称显示
     * @var array
     */
    public $showIndexFields = [

    ];

    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Doc';

    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule(){
        return [
            'name'=>'required',
            'description'=>'required'
        ];
    }



}
