<?php
/**
 * 资源控制器
 * 通过 PhpStorm 创建.
 * 创建人: 21498
 * 日期: 2016/6/14
 * 时间: 13:58
 */

namespace App\Http\Controllers\Traits;


use App\Facades\LifeData;
use App\Models\Menu;
use App\Services\RouteService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

trait ResourceController
{
    /**
     * 绑定模型
     * @var
     */
    protected $bindModel;

    /**
     * 列表页面
     * @return mixed
     */
    public function index()
    {
        $model = $this->newBindModel();
        //查询数据结果
        $data['list'] = $this->list();
        //数据字段映射信息
        $data['maps'] = $this->getFieldsMap($this->showIndexFields, $model);
        //增删改查URL地址
        $data['configUrl'] = $this->getConfigUrl();
        $data['keywordsMap'] = $this->keywordsMap ?: [];
        $excelName = $model->getTable();
        //导出字段选项
        $data['excel'] = [
            'sheet' => $excelName,
            'fileName' => $this->excelName ?: $excelName,
            'exportFields' => $this->getExportFieldsName($this->exportFieldsName, $model)
        ];
        //筛选条件默认选中
        collect($this->sizer)->keys()->filter(function ($value) {
            return Str::endsWith($value, '_id');
        })->map(function ($value) use (&$data) {
            $val = str_replace('_id', '', $value);
            $model = '\App\Models\\' . Str::studly($val);
            $item = [];
            $relation_id = Request::input('where.' . $value, 0);
            if ($relation_id) {
                $fields = isset($this->mapsWhereFields[$value]) ? $this->mapsWhereFields[$value] : ['id', 'name'];
                $item = collect($model::select($fields)
                    ->find($relation_id))->toArray();
            }
            $data['maps'][$value] = $item ? [$item] : [];
        });
        //条件筛选及排序返回
        $this->addOptions();
        $data = $this->handleIndexReturn($data);
        //数据返回
        return Response::returns($data);
    }

    /**
     * 编辑页面
     */
    public function edit($id = 0)
    {
        $id = $id ?: Request::input('id', $id);
        try {
            $data['row'] = $this->one($id);
        } catch (\Exception $exception) {
            return Response::returns(['alert' => alert(['message' => '数据不存在!'], 404)], 404);
        }
        //关系数据处理
        collect($this->editFields)->map(function ($item, $key) use ($id, &$data) {
            if (is_array($item) && Str::endsWith($key, 's')) { //多个关联
                if ($id) {
                    $data['row'][Str::singular($key) . '_ids'] = collect(Arr::get($data, 'row.' . $key, []))->pluck('id')->toArray();
                } else {
                    $data['row'][Str::singular($key) . '_ids'] = [];
                    $data['row'][$key] = [];
                }
            }
        });
        //数据字段映射信息
        $data['maps'] = $this->getFieldsMap($this->editFields, $this->newBindModel());
        //增删改查URL地址
        $data['configUrl'] = $this->getConfigUrl('edit');
        //$data['configUrl']['indexUrl'] = '';
        $data = $this->handleEditReturn($id, $data);
        return Response::returns($data); //获取一条记录
    }

    /**
     * 获取翻页数据
     */
    public function list()
    {
        //指定查询字段
        $fields = $this->selectFields($this->showIndexFields);
        $fields and $this->bindModel = $this->bindModel()->select(in_array($this->newBindModel()->getKeyName(), $fields)
            ? $fields : array_merge([$this->newBindModel()->getKeyName()], $fields));
        //获取带有筛选条件的对象
        $obj = $this->getWithOptionModel();

        //获取分页数据
        if (!Request::input('page') || Request::input('get_count')) {
            $data = $obj->paginate();
        } else { //不统计条数
            $data = $obj->simplePaginate();
        }
        $data = $this->handleListReturn($data);
        //返回响应数据存放,方便操作日志记录
        LifeData::set('list', $data);
        return $data;
    }

    /**
     * 删除数据
     * @return mixed
     */
    public function delete()
    {
        $this->bindModel OR $this->bindModel(); //绑定模型
        $ids = Request::input('ids', []);
        $ids = is_array($ids) ? $ids : [$ids];
        $ids = $this->handleDestroyReturn($ids);
        $res = false;
        if ($ids) {
            $res = $this->bindModel->whereIn('id', $ids)->delete();
        }
        if ($res === false) {
            return Response::returns(['alert' => alert(['message' => '删除失败!'], 500)], 500);
        }
        return Response::returns(['alert' => alert(['message' => '删除成功!'])]);
    }

    /**
     * 执行添加
     */
    public function create(\Illuminate\Http\Request $request)
    {
        $validate = $this->getValidateRule();
        $validator = Validator::make($request->all(), $validate);
        if ($validator->fails()) {
            return Response::returns([
                'errors' => $validator->errors()->toArray(),
                'message' => 'The given data was invalid.'
            ], 422);
        }
        $id = $request->get('id');
        $this->bindModel OR $this->bindModel(); //绑定模型
        $data = $id ? $request->all() : $request->except('id');
        $data['operate_id'] = \App\Models\User::getOperateId();
        //处理修改时日期字段
        $data = $this->handDateFields($data, $this->importExcelDateFields);
        $data = $this->handlePostEditReturn($data);
        $data['updated_at'] = date('Y-m-d H:i:s');
        //新增
        $item = $this->bindModel->create($data);
        if ($item === false) {
            return Response::returns(['alert' => alert(['message' => '新增失败!'], 500)], 500);
        }
        $this->saveRelation($item, $data);
        $this->handlePostEdit($item, $data);
        return Response::returns(['alert' => alert(['message' => '新增成功!'])], 201);
    }

    /**
     * 执行修改
     */
    public function update($id = 0)
    {
        $request = Request::instance();
        $validate = $this->getValidateRule();
        $validator = Validator::make($request->all(), $validate);
        if ($validator->fails()) {
            return Response::returns([
                'errors' => $validator->errors()->toArray(),
                'message' => 'The given data was invalid.'
            ], 422);
        }
        $id = $id ?: $request->get('id', 0);
        $this->bindModel OR $this->bindModel(); //绑定模型
        $data = $id ? $request->all() : $request->except('id');
        $data['operate_id'] = \App\Models\User::getOperateId();
        //处理修改时日期字段
        $data = $this->handDateFields($data, $this->importExcelDateFields);
        $data = $this->handlePostEditReturn($data);
        $item = $this->bindModel->find($id);
        if (!$item) {
            return Response::returns(['alert' => alert(['message' => '数据不存在!'], 404)], 404);
        }
        $res = $item->update($data);
        if ($res === false) {
            return Response::returns(['alert' => alert(['message' => '修改失败!'], 500)], 500);
        }
        $this->saveRelation($item, $data);
        $this->handlePostEdit($item, $data);
        return Response::returns(['alert' => alert(['message' => '修改成功!'])]);
    }


    /**
     * 获取一条编辑数据
     * @param null $id
     * @return \stdClass
     */
    protected function one($id = null)
    {
        $this->bindModel OR $this->bindModel(); //绑定模型
        return $id ? $this->bindModel
            ->with($this->selectWithEidtFields('editFields'))->findOrFail($id) :
            $this->editDefaultFields($this->editFields, $this->newBindModel());
    }

    /**
     * 获取条件拼接对象
     * @return mixed
     */
    protected function getWithOptionModel($fields_key = 'showIndexFields')
    {
        $this->bindModel OR $this->bindModel();
        $obj = $this->bindModel->with($this->selectWithFields($fields_key))
            ->withCount(collect($this->getShowIndexFieldsCount())->filter(function ($item, $key) {
                return !is_array($item);
            })->toArray())
            ->options($this->getOptions());
        return $obj;
    }

    protected function getFieldsMap($showFields, $model, $decode = false)
    {
        $res = $model->getFieldsMap('', $decode);
        foreach ($showFields as $k => $showField) {
            if (is_array($showField)) {
                $res[$k] = $this->getFieldsMap($showField, $model->$k()->getRelated(), $decode);
            }
        }
        return $res;
    }


    /**
     * 查询所需字段
     * @return array
     */
    protected function editDefaultFields($data, $model)
    {
        $result = [];
        $defult = $this->getDefault($model);//默认值
        $fields = [];
        foreach ($data as $key => $row) {
            if (is_array($row)) {
                $result[$key] = $this->editDefaultFields($row, $model->$key()->getRelated());
            } else {
                $fields[] = $row;
            }
        }
        $result1 = $fields ? collect($defult)->filter(function ($item, $key) use ($fields, $model) {
            return in_array($key, array_merge($fields, [$model->getKeyName()]));
        })->toArray() : $defult;
        return array_merge($result1, $result);
    }


    /**
     * 保存关系数据
     */
    protected function saveRelation($item, $data)
    {
        //关系数据处理
        collect($this->editFields)->map(function ($item1, $key) use ($data, $item) {
            $key1 = Str::singular($key) . '_ids';
            if (is_array($item1) && Str::endsWith($key, 's') && isset($data[$key1])) { //多个关联
                $item->$key()->sync(Arr::get($data, $key1, []));
            }
        });
    }


    /**
     * 获取字段默认值
     * @param $model_name
     * @return \stdClass
     */
    protected function getDefault($model)
    {
        $default = $model->getFieldsDefault();
        return collect(array_flip(array_merge([$model->getKeyName()], $model->getFillable())))->map(function ($item, $key) use ($default) {
            return Arr::get($default, $key, null);
        })->toArray() ?: new \stdClass();
    }

    /**
     * 获取绑定的资源模型
     * @return mixed
     */
    protected function getResourceModel()
    {
        return $this->resourceModel ?: str_replace('Controller', '', class_basename(get_class()));
    }


    public function newBindModel()
    {
        $resourceModel = $this->getModelNamespace() . $this->getResourceModel();
        return new $resourceModel();
    }

    /**
     * 绑定模型
     * @return mixed
     */
    protected function bindModel()
    {
        if (!$this->bindModel) {
            $this->bindModel = $this->newBindModel();
        }
        return $this->bindModel;
    }

    /**
     * 设置模型的命名空间
     * @return mixed
     */
    protected function getModelNamespace()
    {
        if (!isset($this->modelNamespace)) {
            $this->modelNamespace = 'App\\Models\\';
        }
        return $this->modelNamespace;
    }

    /**
     * 结果返回添加筛选条件跟排序
     */
    protected function addOptions()
    {
        LifeData::set('options', [
            'where' => LifeData::get('_condition.where', new \stdClass()),
            'order' => LifeData::get('_condition.order', new \stdClass())
        ]);
    }

    /**
     * 获取资源控制器操作地址
     * @return static
     */
    protected function getConfigUrl($type = 'index')
    {
        $main = Route::getCurrentRoute()
            ->getCompiled()
            ->getStaticPrefix();
        $main = Menu::realRoute($main);
        $data = collect(RouteService::getResourceRoutes())->map(function ($item, $key) use ($main, $type) {
            $item['path'] = $item['route'] ? $main . '/' . $item['route'] : $main;
            $item['key'] = $key . 'Url';
            return $item;
        })->keyBy('key');
        if ($this->checkPermission) {
            $data = $data->map(function ($item) {
                $item['path'] = Menu::hasPermission($item['path'], $item['method']['type']) ? $item['path'] : '';
                return $item;
            });
        }
        return $data->map(function ($item) {
            return $item['path'];
        });
    }

    /**
     * 新增或修改,验证规则获取
     * @return mixed
     */
    abstract protected function getValidateRule();

    /**
     * 导入验证规则
     * @return array
     */
    protected function getImportValidateRule($id = 0, $item)
    {
        return [];
    }

    protected function getShowIndexFieldsCount()
    {
        if ($this->showIndexFieldsCount) {
            return $this->showIndexFieldsCount;
        }
        return [];
    }

    protected function getExportFields($fields, $model)
    {
        $res = [];
        $select_fields = $this->selectFields($fields);
        if (!$select_fields) {
            $res = $model->getKeyName() ? array_merge(array_merge($res, $model->getFillable()), [$model->getKeyName()]) : array_merge($res, $model->getFillable());
        } else {
            $res = (in_array($model->getKeyName(), $select_fields) || !$model->getKeyName()) ? $select_fields : array_merge($select_fields, [$model->getKeyName()]);
        }
        foreach ($fields as $key => $field) {
            if (is_array($field)) {
                $res[$key] = $this->getExportFields($field, $model->$key()->getRelated());
            }
        }
        return $res;
    }

    protected function relationName($names, $model, $tableCommentFlog = false)
    {
        $res = [];
        $maps = $model->getFieldsName();//本表字段说明
        $tableComment = $tableCommentFlog ? $model->getTableComment() : ''; //表备注
        collect($names)->map(function ($value, $key) use (&$res, $maps, $tableComment) {
            if (Str::startsWith($key, '$index')) {
                $key1 = str_replace('$index.', '', $key);
            } else {
                $key1 = $key;
            }
            if (!str_contains(str_replace('$index.', '', $key1), '.')) {
                if (!$value) {
                    $value1 = $tableComment . Arr::get($maps, $key1, $key);
                } else {
                    $value1 = $value;
                }
                if ($key1 != $key) {
                    $res['$index'][$key1] = $value1;
                } else {
                    $res[$key] = $value1;
                }
            } else {
                $relations = explode('.', $key);
                $relation = array_shift($relations);
                if (!isset($res[$relation]) || !is_array($res[$relation])) {
                    $res[$relation] = [];
                }
                $res[$relation][implode('.', $relations)] = $value;
            }
        });
        $res = collect($res)->map(function ($value, $key) use ($model) {
            if (is_array($value) && $key != '$index') {
                return $this->relationName($value, $model->$key(), true);
            } else {
                return $value;
            }
        })->toArray();
        return $res;

    }

    /**
     * 获取处理导出字段
     */
    protected function getExportFieldsName($fieldsName, $model)
    {
        if (!$fieldsName) {
            return $model->getFieldsName();
        }
        $names = []; //所有含有键名称字段
        collect($fieldsName)->map(function ($value, $key) use (&$names) {
            if (is_numeric($key)) {
                $names[$value] = '';
            } else {
                $names[$key] = $value;
            }
        });
        $maps = $this->relationName($names, $model);
        //dd($maps);
        return collect($names)->map(function ($value, $key) use ($maps) {
            return Arr::get($maps, $key, $key);
        })->toArray();
    }


    /**
     * 导出数据
     */
    public function export()
    {
        $model = $this->newBindModel();
        $exportFieldsName = $this->exportFieldsName;
        if ($exportFieldsName) {
            $exportFieldsName = $this->getExportFieldsName($this->exportFieldsName, $model);
            $all_titles = [];
            $keys = array_keys($exportFieldsName);
        } else {
            //所有要导出的字段
            $keys = toLateralKey($this->getExportFields($this->exportFields, $model));
            $all_titles = $this->relationTables($this->exportFields, $model);
        }
        //指定查询字段
        $export_fileds = Request::get('export_fileds', []);
        if ($export_fileds) {
            $fields_key = collect($keys)->intersect($export_fileds)->values()->toArray();
        } else { //导出所有
            $fields_key = $keys;
        }
        $title = collect($fields_key)->map(function ($item) use ($all_titles, $exportFieldsName) {
            return isset($exportFieldsName[$item]) ? $exportFieldsName[$item] : Arr::get($all_titles, $item, '');
        });
        $fields = $this->selectFields($this->exportFields);
        $fields and $this->bindModel = $this->bindModel()->select(in_array($model->getKeyName(), $fields)
            ? $fields : array_merge([$model->getKeyName()], $fields));
        //获取带有筛选条件的对象
        $obj = $this->getWithOptionModel('exportFields');
        //获取分页数据
        if (!Request::input('page')) {
            $data = $obj->paginate(200)->toArray();
            //表头数据放入
        } else { //不统计条数
            $data = $obj->simplePaginate(200)->toArray();
        }
        $maps = $this->getFieldsMap($this->exportFields, $model);
        $multipleFields = collect($this->exportFieldsName)->filter(function ($v, $k) {
            return str_contains($k, '$index');
        })->keys()->toArray();
        $data['data'] = collect($data['data'])->map(function ($item) use ($fields_key, $maps, $multipleFields) {
            $row = collect($fields_key)->map(function ($key) use ($item, $maps, $multipleFields) {
                $value = Arr::get($item, $key, '');
                $map = Arr::get($maps, $key);
                if (in_array($key, $multipleFields)) {
                    $k_arr = explode('.$index.', $key);
                    $value = collect(Arr::get($item, $k_arr[0], []))->pluck($k_arr[1])->implode(',');
                } elseif ($map) {
                    if (!is_array($value)) {
                        $value = Arr::get($map, $value);
                    } else {
                        $value = collect($value)->map(function ($value) use ($map) {
                            return Arr::get($map, $value);
                        })->implode(',');
                    }
                }
                $value = $this->handleExportValue($item, $key, $maps, $value);
                return $value;
            });
            return $row;
        });
        if (!Request::input('page')) {
            $data['data'] = $data['data']
                ->prepend($title->toArray()) //标题
                ->prepend($fields_key); //key
        }
        return $data;
    }

    protected function handleExportValue($item, $key, $maps, &$value = '')
    {
        return $value;
    }

    protected function handleImportMaps(&$maps)
    {
        return $maps;
    }


    /**
     * 导入数据
     */
    public function import()
    {
        $model = $this->newBindModel();
        $maps = $this->getFieldsMap($this->exportFields, $model, true);
        $maps = $this->handleImportMaps($maps);
        $default = $this->editDefaultFields($this->exportFields, $model);
        $key_name = $model->getKeyName();
        $bindModel = $this->getModelNamespace() . $this->getResourceModel();
        $errors = []; //错误数据项
        $relation_keys = []; //关系数据
        $datas = collect(Request::input('datas', []) ?: [])->map(function ($row) use ($maps, $default, &$relation_keys, $model) { //数据解码
            $relation_row = [];
            $row = collect($row)->map(function ($item, $key) use ($maps, $default, &$relation_keys, $model, &$relation_row) {
                //日期数据处理
                if (in_array($key, isset($this->importExcelDateFields) ? $this->importExcelDateFields : [])) {
                    return excelDate($item);
                }
                $map = Arr::get($maps, $key);
                if ($map) {
                    if (is_array(Arr::get($default, $key)) || in_array($key, $this->importMultipleFields)) { //多选值
                        $value = collect(explode(',', trim($item)))->map(function ($item) use ($map) {
                            return Arr::get($map, trim($item));
                        })->filter(function ($item) {
                            return !is_null($item);
                        })->toArray();
                    } else {
                        $value = Arr::get($map, trim($item), Arr::get($default, $key));
                    }
                } else {
                    $value = is_null($item) ? Arr::get($default, $key) : trim($item);
                }
                if (isset($relation_keys[$key]) || (($keys = explode('.', $key)) && Arr::get($keys, 1) == '$index' && count($keys) == 3)) {
                    $relation_keys[$key] = Str::singular(Arr::get($keys, 0)) . '_ids';
                    $relation = Arr::get($keys, 0);
                    $relationModel = $model->$relation()->getClassName();
                    $relation_row[$relation_keys[$key]] = collect($relationModel::whereIn(Arr::get($keys, 2), explode(',', $value))->pluck('id'))->toArray();
                }
                return $value;
            })->merge($relation_row)->toArray();
            return $row;
        })->filter(function ($item) use (&$errors, $key_name, $relation_keys) { //数据验证
            $validator = Validator::make($item, $this->getImportValidateRule(Arr::get($item, $key_name, 0), $item), [], $this->exportFieldsName);
            $flog = !$validator->fails(); //验证状态
            if ($validator->fails()) {
                $item['error'] = collect($validator->errors()->toArray())->map(function ($v, $k) {
                    return collect($v)->implode(";");
                })->implode(';');//错误信息
                //去除关联添加数据
                $item = collect($item)->except($relation_keys)->toArray();
                $errors[] = $item;
            }
            return $flog;
        })->toArray(); //读取数据
        foreach ($datas as $row) {
            $item = $bindModel::updateOrCreate([$key_name => Arr::get($row, $key_name) ?: null], $row); //更新,创建数据
            $this->saveRelation($item, $row);
            $this->handlePostEdit($item, $row);
        }
        return [
            "message" => '导入成功',
            "errors" => $errors,
        ];
    }

    protected function select2Map($row, $key)
    {
        if (!Arr::get($row, $key) || !Arr::get($row, 'id')) {
            return [];
        }
        return [
            Arr::get($row, $key)
        ];
    }

    /**
     * 处理编辑页面的删除日期字段
     */
    protected function handDateFields($data, $fields = [])
    {
        //处理修改时日期字段
        collect($fields ?: [])->map(function ($value) use (&$data) {
            isset($data[$value]) and !$data[$value] and $data[$value] = null;
        });
        return $data;
    }

    /**
     * 列表页面返回数据前对数据处理
     * @param $data
     * @return mixed
     */
    protected function handleIndexReturn(&$data)
    {
        return $data;
    }

    /**
     * 列表页面返回数据前对数据处理
     * @param $data
     * @return mixed
     */
    protected function handleListReturn(&$data)
    {
        return $data;
    }

    /**
     * 执行修改前对数据进行处理
     * @param $data
     * @return mixed
     */
    protected function handlePostEditReturn(&$data)
    {
        return $data;
    }

    /**
     * 执行删除数据前对数据进行处理
     * @param $data
     * @return mixed
     */
    protected function handleDestroyReturn(&$data)
    {
        return $data;
    }

    /**
     * 编辑页面返回数据前对数据处理
     * @param $data
     * @return mixed
     */
    protected function handleEditReturn($id, &$data)
    {
        return $data;
    }

    /**
     * 保存数据后对返回数据处理
     * @param $item
     * @param $data
     */
    protected function handlePostEdit($item, $data)
    {

    }

}
