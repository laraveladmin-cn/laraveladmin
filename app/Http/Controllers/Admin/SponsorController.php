<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Sponsor;
use Illuminate\Support\Facades\Response;

class SponsorController extends Controller
{
    use ResourceController;

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
            'name' => 'sometimes|required|alpha_dash|between:2,100',
            'url' => 'sometimes|required|active_url',
            'logo' => 'sometimes|required|active_url'
        ];
        return $validate;
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
