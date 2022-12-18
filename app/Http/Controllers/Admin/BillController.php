<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Bill;
use Illuminate\Support\Facades\Response;

class BillController extends Controller
{
    use ResourceController;

    protected $sizer=[
        'member_id'=>'=',
        'donation_id'=>'=',
        'status'=>'='
    ];

    public $showIndexFields=[
        'member'=>['user'=>[]],
        'donation'=>[]
    ];
    public $editFields=[
        'donation'=>[
            'member'=>[
                'user'=>[]
            ]
        ],
        'member'=>['user'=>[]],
    ];

    public $mapsWhereFields=[
        'donation_id'=>['id','amount']
    ];


    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Bill';

    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule(){
        $validate = [];
        return $validate;
    }

    /**
    * 编辑页面数据返回处理
    * @param  $id
    * @param  $data
    * @return  mixed
    */
    protected function handleEditReturn($id,&$data){
        $data['maps']['member_id'] = mapOption($data['row'],'member_id');
        $data['maps']['donation_id'] = mapOption($data['row'],'donation_id');
        return $data;
    }



}
