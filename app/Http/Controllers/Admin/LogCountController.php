<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
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
            $this->bindModel = $this->newBindModel()
                ->main('=')
                ->groupBy(DB::raw('LEFT(created_at,10)'));
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
        'LEFT(`created_at`,10) as date',
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






}
