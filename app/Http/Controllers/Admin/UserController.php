<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    use ResourceController;

    //默认排序
    protected $orderDefault = [
        'updated_at' => 'desc',
        'id' => 'asc',
    ];


    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'User';

    /**
     * 筛选过滤
     * @var array
     */
    protected $sizer = [
        'status' => '=',
        'created_at' => [
            '>=',
            '<=',
        ],
        'admin' => 'has',
        'name|uname' => 'like',
        'name|uname|mobile_phone|email' => 'like',
        'id' => 'or',
    ];

    protected $keywordsMap = [
        'name|uname|mobile_phone|email' => '用户',
    ];


    /**
     * Index页面字段名称显示
     * @var array
     */
    public $showIndexFields = [
        'id',
        'uname',
        'name',
        'mobile_phone',
        'email',
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * 编辑页面时的字段值
     * @var array
     */
    public $editFields = [];

    public $exportFieldsName = [];

    /**
     * 添加或修改时数据验证规则
     *
     * @param Request $request
     * @return array
     */
    protected function getValidateRule(Request $request)
    {
        $id = $request->input('id', 0);
        //没有密码值不对密码进行修改
        if ( ! $request->password ) {
            $request->offsetUnset('password');
        }

        return [
            'uname' => 'sometimes|required|alpha_dash|between:5,18|unique:users,uname,' . $id . ',id,deleted_at,NULL',
            'password' => ($id ? 'sometimes|' : '') . 'required|between:6,18',
            'name' => 'required',
            'email' => 'sometimes|required|email|unique:users,email,' . $id . ',id,deleted_at,NULL',
            'mobile_phone' => 'sometimes|required|mobile_phone|unique:users,mobile_phone,' . $id . ',id,deleted_at,NULL',
            'status' => 'nullable|in:0,1,2',
        ];
    }


    /**
     * 获取条件拼接对象
     * @return mixed
     */
    public function getWithOptionModel()
    {
        $this->bindModel OR $this->bindModel();
        $obj = $this->bindModel->with($this->selectWithFields())
            ->withCount(collect($this->getShowIndexFieldsCount())->filter(function ($item) {
                return !is_array($item);
            })->toArray())
            ->whereDoesntHave('admin') // 不显后台用户
            ->options($this->getOptions());

        return $obj;
    }

    protected function handlePostEditReturn(&$data)
    {
        if( Arr::get($data, 'id') === 1 ){
            unset($data['status']);
        }

        return $data;
    }

    /**
     * @param $data
     * @return array
     */
    protected function handleDestroyReturn(&$data)
    {
        $data = collect($data)->filter(function ($id) {
            return $id > 1;
        })->toArray();

        return $data;
    }
}
