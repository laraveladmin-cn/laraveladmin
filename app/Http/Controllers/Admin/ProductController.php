<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Classify;
use App\Models\Firm;
use App\Models\Pclassify;
use App\Models\Product;
use App\Models\Year;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
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


    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule($id=0){
        $id = $id ?: Request::input('id',0);
        $_onlyUpdate = Request::input('_onlyUpdate','');
        $validate = [
            'name'=>'required',
            'order'=>'sometimes|integer',
            'is_long_time'=>'sometimes|integer|in:0,1'
        ];
        if($id && $_onlyUpdate){
            $validate = collect($_onlyUpdate)->only($_onlyUpdate)->toArray();
        }
        return $validate;
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
            collect(Pclassify::where('left_margin','<=',Arr::get($data,'row.pclassify.left_margin',0))
                ->where('right_margin','>=',Arr::get($data,'row.pclassify.right_margin',0))
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

    /**
     * 执行修改前对数据进行处理
     * @param $data
     * @return mixed
     */
    protected function handlePostEditReturn(&$data)
    {
        $id = Request::input('id',0);
        $_onlyUpdate = Request::input('_onlyUpdate','');
        if($id && $_onlyUpdate){
            $data = collect($data)->only($_onlyUpdate)->toArray();
        }
        return $data;
    }

    /**
     * 列表页面返回数据前对数据处理
     * @param $data
     * @return mixed
     */
    protected function handleListReturn(&$data, $obj)
    {
        $this->bindModel = null;
        $obj = $this->bindModel();
        $options = $this->getOptions(); //筛选项+排序项
        $data = collect($data)->toArray();
        $sql = [];
        collect(Product::getFieldsMap('status'))->each(function ($value,$key)use(&$sql){
            $sql[] = 'SUM(CASE WHEN `status`='.$key.' THEN 1 ELSE 0 END) AS value'.$key;
        });
        $data['count_status'] = (clone $obj)->options(
            collect($options)->only(['where'])->toArray()
        )
            ->select(DB::raw(collect($sql)->implode(',')))->first();
        return $data;
    }

}
