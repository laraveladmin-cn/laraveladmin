<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    protected $maps = [
        'image'=>[
            'base_path'=>'/uploads/images/',
            'path'=>'Y/m/d',
            'validate'=>'required|file|image|max:2048'
        ]
    ];

    /**
     * 上传文件
     * @return mixed
     */
    public function postIndex(){
        $request = Request::instance();
        $validate = $this->getValidateRule();
        $validator = Validator::make($request->all(), $validate);
        if ($validator->fails()) {
            return Response::returns([
                'errors' => $validator->errors()->toArray(),
                'message' => 'The given data was invalid.'
            ], 422);
        }
        $type = $request->input('type','image'); //上传类型
        $disk = $request->input('disk','public'); //上传磁盘
        $file = $request->file('file');
        $map =  Arr::get($this->maps,$type);
        $path = $map['base_path'].date($map['path']);
        $path_file = Storage::disk($disk)->putFile($path,$file);
        if(!$path_file){
            return Response::returns(['alert' => alert([
                'message' => trans('Upload failed!'),
                'success'=>0], 500)],500);
        };
        return Response::returns([
            'url'=>Storage::disk($disk)->url($path_file),
            'path'=>$path_file,
            'save_name'=>basename($path_file),
            'state'=>'SUCCESS',
            'success'=>1,
            'message'=>trans("Uploaded successfully!")
        ]);

    }

    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule()
    {
        $request = Request::instance();
        $type = $request->input('type','image'); //上传类型
        return [
            'file' => Arr::get($this->maps,$type.'.validate',''), //文件验证
            'type'=>'nullable|in:'.collect($this->maps)->keys()->implode(','), //上传类型
            'disk'=>'nullable|in:public' //上传磁盘
        ];
    }

}
