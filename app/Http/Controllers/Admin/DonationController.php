<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Donation;
use Illuminate\Support\Facades\Response;

class DonationController extends Controller
{
    use ResourceController;

    protected $sizer=[
        'from'=>'=',
        'sponsor.name'=>'like',
        'member.user.name'=>'like',

    ];

    /**
     * Index页面字段名称显示多条数据统计值
     * @var array
     */
    public $showIndexFieldsCount=[
        'bills'
    ];

    /**
     * 其它筛选条件输出
     * @var array
     */
    protected $otherSizerOutput = [
        '_key' => 'member.user.name' //默认使用的关键字
    ];

    /**
     * 关键字搜索组
     * @var array
     */
    protected $keywordsMap=[
        'sponsor.name'=>'捐赠会员',
        'member.user.name'=>'赞助商',
    ];

    /**
     * Index页面字段名称显示
     * @var array
     */
    public $showIndexFields=[
        'member'=>['id','user_id','user'=>['id','name']],
        'sponsor'=>['id','name']
    ];


    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Donation';

    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule()
    {
        $validate = [
            'member_id' => 'required|integer|exists:members,id',
            'sponsor_id' => 'required|integer|exists:donations,id',
            'amount' => 'sometimes|required|number|min:0.02'
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
        $data['maps']['member_id'] = mapOption($data['row'], 'member_id');
        $data['maps']['sponsor_id'] = mapOption($data['row'], 'sponsor_id');
        return $data;
    }


}
