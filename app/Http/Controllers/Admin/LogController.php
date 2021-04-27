<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

class LogController extends Controller
{
    use ResourceController;

    /**
     * LogController constructor.
     */
    public function __construct()
    {
        $this->sizerDefault = [
            'created_at' => [
                Carbon::now()->startOfDay()->toDateTimeString(),
                '',
            ],
        ];
    }

    /**
     * 资源模型
     *
     * @var  string
     */
    protected $resourceModel = 'Log';

    protected $sizer = [
        'menu_id' => '=',
        'user_id' => '=',
        'parameters' => 'like',
        'created_at' => [
            '>=',
            '<=',
        ],
    ];

    protected $mapsWhereFields = [
        'menu_id' => [
            'id',
            'name',
            'url',
        ],
    ];
    /**
     * Index页面字段名称显示
     *
     * @var array
     */
    public $showIndexFields = [
        'id',
        'user_id',
        'menu_id',
        'location',
        'ip',
        'parameters',
        'created_at',

        'user' => [
            'id',
            'name',
            'uname',
        ],

        'menu' => [
            'id',
            'name',
            'parent_id',
            'resource_id',
            'parent'=>[
                'id',
                'name',
                'item_name'
            ]
        ],
    ];
    /**
     * excel导出数据字段
     *
     * @var array
     */
    public $exportFields = [
        'user' => [
            'id',
            'name',
            'uname',
        ],

        'menu' => [
            'id',
            'name',
        ],
    ];


    //字段导出
    public $exportFieldsName = [
        'menu.name' => '操作菜单',
        'user.name' => '操作者',
        'location' => '位置',
        'ip' => 'IP地址',
        'parameters' => '请求参数',
        'return' => '返回数据',
        'id' => 'ID',
    ];

    /**
     * 编辑页面查询字段
     * @var array
     */
    public $editFields = [
        'menu' => [
            'id',
            'name',
            'url',
        ],

        'user' => [
            'id',
            'name',
        ],
    ];


    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule()
    {
        $id = Request::input('id',0);

        return [];
    }

    /**
     * @param $id
     * @param $item
     * @return array
     */
    protected function getImportValidateRule($id, $item)
    {
        $validate = [];

        return $validate;
    }

    /**
     * 列表页面返回数据处理
     *
     * @param $data
     * @return mixed
     */
    protected function handleIndexReturn(&$data)
    {
        $data['configUrl']['createUrl'] = '';
        $data['configUrl']['updateUrl'] = '';
        $data['configUrl']['importUrl'] = ''; //不需要导入数据

        return $data;
    }

    /**
     * 编辑页面数据返回处理
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    protected function handleEditReturn($id, &$data)
    {
        $data['configUrl']['createUrl'] = '';
        $data['configUrl']['updateUrl'] = '';

        return $data;
    }

}
