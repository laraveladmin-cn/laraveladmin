<?php

namespace App\Http\Controllers\Admin;

use App\Facades\LifeData;
use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class LogCountController extends Controller
{
    use ResourceController;

    public function __construct()
    {
        $this->sizerDefault = [
            'created_at' => [
                Carbon::now()->subDay(7)->startOfDay()->toDateTimeString(),
                '',
            ],
            'user_id' => 0,
            'menu.method' => 2,
            'menu.url' => '/open/login'
        ];
    }

    /**
     * 默认排序
     * @var array
     */
    protected $orderDefault = [];

    /**
     * 资源模型
     *
     * @var  string
     */
    protected $resourceModel = 'Log';

    /**
     * 绑定模型
     *
     * @return mixed
     */
    protected function bindModel()
    {
        if ( ! $this->bindModel ) {
            $map = [
                'LEFT(`created_at`,10)',//'按天',
                'DATE_FORMAT(`created_at`,"%X-%v")',//'按周',
                'LEFT(`created_at`,7)',//'按月',
                'CONCAT(DATE_FORMAT(`created_at`, "%Y"),"-",FLOOR((DATE_FORMAT(`created_at`, "%m")+2)/3))',//'按季度',
                'LEFT(`created_at`,4)',//'按年'
            ];
            $group = Request::input('group',0);
            $group_str = Arr::get($map,$group,$map[0]);
            $this->bindModel = $this->newBindModel()
                ->main('=')
                ->groupBy(DB::raw($group_str));
            $this->showIndexFields[0] = $group_str.' as `date`';
        }

        return $this->bindModel;
    }

    protected $sizer = [
        'menu_id' => '=',
        'user_id' => '<>',
        'parameters' => 'like',
        'created_at' => [
            '>=',
            '<=',
        ],
        'menu.url'=>'=',
        'menu.method'=>'&'
    ];

    /**
     * Index页面字段名称显示
     *
     * @var array
     */
    public $showIndexFields = [
        'LEFT(`created_at`,10) as `date`',
        'COUNT(DISTINCT `ip`) as distinct_value',
        'COUNT(*) as `value`'
    ];

    //字段导出
    public $exportFieldsName = [
        'date' => '日期',
        'distinct_value' => 'IP排重数',
        'value' => '总数'
    ];

    protected $noPrimaryKey = true;

    /**
     * 默认每页取多少条
     * @var int
     */
    protected $per_page = 200;

    /**
     * 结果返回添加筛选条件跟排序
     */
    protected function addOptions()
    {
        LifeData::set('options', [
            'where' => LifeData::get('_condition.where', new \stdClass()),
            'order' => LifeData::get('_condition.order', new \stdClass()),
            'group'=>Request::input('group',0)-0,
        ]);
    }







}
