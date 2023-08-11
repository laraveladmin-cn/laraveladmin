<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\App;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AppController extends Controller
{
    use ResourceController;


    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'App';

    /**
     * 筛选条件
     * @var array
     */
    public $sizer = [
        'type'=>'=',
        'id'=>'>',
        'version'=>'=',
        'name|version'=>'like'
    ];

    public $orderDefault=[
        'id'=>'desc'
    ];

    /**
     * 验证规则
     * @return    array
     */
    protected function getValidateRule($id=0)
    {
        return $this->getImportValidateRule($id,Request::all());
    }

    /**
     * 验证规则
     * @return  array
     */
    protected function getImportValidateRule($id = 0, $item){
        $validate = [
            'type'=>'sometimes|in:0,1',
            'name'=>'required',
            'description'=>'required',
            'url'=>'required|url',
            'version'=>'required',
            'forced_update'=>'sometimes|in:0,1'
        ];
        return $validate;
    }

    /**
     * 编辑页面数据返回处理
     * @param  $id
     * @param  $data
     * @return  mixed
     */
    protected function handleEditReturn($id,&$data){
        return $data;
    }

    /**
     * 版本信息
     * @return void
     */
    public function versionInfo(){
        $request = Request::instance();
        $app_ver = $request->header('app_ver'); //应用版本号
        $tyep_name = $request->header('From-App')?:$request->input('type_name');
        $type = $tyep_name=='ios'?2:1;//类型
        $app_id = App::query()
            ->where('type',$type)
            ->where('version',$app_ver)
            ->value('id')?:0;
        $latest = App::query()
            ->where('type',$type)
            ->orderBy('id','desc')
            ->first();
        $forced_update = App::query()
            ->where('type',$type)
            ->where('id','>',$app_id)
            ->where('forced_update',1)
            ->value('id')?1:0;
        $minimum = App::query()
            ->where('type',$type)
            ->where('id','<>',Arr::get($latest,'id',0))
            ->orderBy('id','desc')
            ->first();
        $app_logo_url = Option::get('app_logo_url','');
        return Response::returns([
            'version_info'=>[
                'forced_update'=>$forced_update,
                'latest_ver'=>[
                    'apk_url'=>Arr::get($latest,'url',''),
                    'update_info'=>Arr::get($latest,'description',''),
                    'ver_no'=>Str::replace(['v','V'],'',Arr::get($latest,'version','')),
                    'logo_url'=>Arr::get($latest,'logo_url','')?:$app_logo_url
                ],
                'minimum_ver'=>[
                    'apk_url'=>Arr::get($minimum,'url',''),
                    'update_info'=>Arr::get($minimum,'description',''),
                    'ver_no'=>Str::replace(['v','V'],'',Arr::get($minimum,'version','')),
                    'logo_url'=>Arr::get($minimum,'logo_url','')?:$app_logo_url
                ]
            ]
        ]);

    }


}
