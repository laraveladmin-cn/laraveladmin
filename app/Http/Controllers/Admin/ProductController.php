<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Classify;
use App\Models\Firm;
use App\Models\Pclassify;
use App\Models\Year;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    use ResourceController;

    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Product';

    //默认排序
    protected $orderDefault = [
        'updated_at' => 'desc',
        'id'=>'asc'
    ];

    /**
     * 列表页面查询字段
     * @var array
     */
    public $showIndexFields=[
        'id','classify_id','classify2_id','firm_id','name','status','is_long_time','created_at','updated_at',
        'firm'=>['id','name'],
        'classify'=>['id','name'],
        'classify2'=>['id','name']
    ];

    //条件筛选
    protected $sizer=[
        'firm_id'=>'=',
        'classify_id'=>'=',
        'classify2_id'=>'=',
        'status'=>'=',
        'is_long_time'=>'=',
        'name'=>'like',
    ];

    /**
     * 编辑页面查询字段
     * @var array
     */
    public $editFields = [
        'firm'=>['id','name'],
        'classify'=>['id','name'],
        'classify2'=>['id','name'],
        'pclassify'=>['id','name','left_margin','right_margin'],
        'years'=>[
            'years.id','name','value'
        ]
    ];

    public $exportFields = [
        'firm'=>['id','name'],
        'classify'=>['id','name'],
        'classify2'=>['id','name'],
        'pclassify'=>['id','name','left_margin','right_margin'],
        'years'=>[
            'years.id','name','value'
        ]
    ];

    //字段导出
    public $exportFieldsName = [
        'firm.name'=>'保险公司',
        'abbreviation'=>'简称',
        'name'=>'全称',
        'code'=>'代码',
        'uid'=>'唯一标识',
        'id'=>'ID',
    ];


    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule(){
        return ['name'=>'required','order'=>'sometimes|integer'];
    }

    /**
     * 编辑页面数据返回处理
     * @param $id
     * @param $data
     * @return mixed
     */
    protected function handleEditReturn($id,&$data){
        //查询分组数据
        $data['row']['pclassify_ids'] = $data['row']['pclassify_id']?
            collect(Pclassify::where('left_margin','<=',$data['row']['pclassify']['left_margin'])
                ->where('right_margin','>=',$data['row']['pclassify']['right_margin'])
                ->where('id','<>',1)
                ->orderBy('left_margin','asc')
                ->pluck('id'))->toArray()
            :[];
        $data['maps']['pclassify_ids'] = listToTree(collect(Pclassify::get(['id','name','parent_id']))->toArray(),'id', 'parent_id',  'children', 1);
        //分类数据
        $data['maps']['classify_id'] = collect(listToTree(collect(Classify::get(['id','name','parent_id']))->toArray(),'id', 'parent_id',  'children', 1))->keyBy('id')->toArray();
        //查询所有年期
        $data['maps']['year_ids'] = Year::optionsMap();
        return $data;
    }

}