<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    protected $maps = [
        'image'=>[
            'base_path'=>'/uploads/images/',
            'path'=>'Y/m/d'
        ]
    ];
    public function postIndex(\Illuminate\Http\Request $request){
        $this->validate($request, $this->getValidateRule()); //验证数据
        $type = $request->input('type','image'); //上传类型
        $disk = $request->input('disk','public'); //上传磁盘
        $file = $request->file('file');
        $map =  Arr::get($this->maps,$type);
        $path = $map['base_path'].date($map['path']);
        $path_file = Storage::disk($disk)->putFile($path,$file);
        if(!$path_file){
            return Response::returns(['alert' => alert(['message' => '上传失败!'], 500)],500);
        };
        return Response::returns([
            'url'=>Storage::disk($disk)->url($path_file),
            'path'=>$path_file,
            'save_name'=>basename($path_file),
            'state'=>'SUCCESS'
        ]);

    }

    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule()
    {
        return [
            'file' => 'required|file|image|max:'.(1024*2), //文件验证
            'type'=>'nullable|in:image', //上传类型
            'disk'=>'nullable|in:public' //上传磁盘
        ];
    }

}
