<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Arr;
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

    public $editFields=[
        'member'=>[
            'id','user_id',
            'user'=>[
                'id',
                'name',
                'uname'
            ]
        ],
        'sponsor'=>[
            'id','name'
        ]

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
            'sponsor_id' => 'required|integer|exists:sponsors,id',
            'amount' => 'sometimes|required|min:0.02'
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

    /**
     * 执行修改前查询到数据结果后对数据进行处理
     * @param $data
     * @param $item
     * @return mixed
     */
    protected function handlePostEditFindReturn(&$data,$item){
        $member = Member::query()->find($data['member_id']);
        $amount = $data['amount'];
        $data['name'] = Arr::get($member,'user.name','')."捐赠: {$amount} 元";
        return $data;
    }

    /**
     * 保存数据后对返回数据处理
     * @param $item
     * @param $data
     */
    protected function handlePostEdit($item, $data,$old_data=[])
    {
        if(!$old_data){ //新增数据
            $item->createBills();
        }
    }


}
