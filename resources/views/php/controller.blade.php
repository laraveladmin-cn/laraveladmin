{!! $php !!}

namespace {{$namespace}};

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
@if ($model_namespace)
use {{$model}};
@else
use App\{{$model}};
@endif
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Arr;

class {{$name}}Controller extends Controller
{
    use ResourceController;

@if ($model_namespace)
    /**
     * 模型命名空间
     * @var string
     */
    protected $modelNamespace = '\\{{$model_namespace}}';
@endif

    /**
     * 资源模型
     * @var string
     */
    protected $resourceModel = '{{$modelName}}';

    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule($id=0)
    {
@foreach ($tableInfo['table_fields'] as $table_field)
    @if ($table_field['showType']=='password')
        if(!Request::input('{{$table_field['Field']}}')){
            Request::offsetUnset('{{$table_field['Field']}}');
        }
    @endif
@endforeach
        return $this->getImportValidateRule($id,Request::all());
    }

    /**
     * 验证规则
     * @return array
     */
    protected function getImportValidateRule($id = 0, $item){
        $validate = [{!! $validates !!}];
@if ($is_tree_model)
        if(!{{$modelName}}::where('id',1)->value('id')  || Arr::get($item,'id')==1){
            unset($validate['parent_id']);
        }
@endif
        return $validate;
    }

    /**
    * 编辑页面数据返回处理
    * @param $id
    * @param $data
    * @return mixed
    */
    protected function handleEditReturn($id,&$data){
@if ($is_tree_model)
        //树状结构可选数据
        $data['maps']['optional_parents'] = {{$modelName}}::optionalParent($id ? $data['row'] : null)
        ->orderBy('left_margin', 'asc')
        ->get(['id','name','parent_id','level','left_margin','right_margin']);
        $data['no_root'] = !{{$modelName}}::where('id',1)->value('id') || $id==1;
@endif
@foreach ($tableInfo['table_relations'] as $table_relation)
@if ($table_relation['relation']=='belongsTo')
        $data['maps']['{{$table_relation['name']}}_id'] = mapOption($data['row'],'{{$table_relation['name']}}_id');
@endif
@endforeach
        return $data;
    }


}
