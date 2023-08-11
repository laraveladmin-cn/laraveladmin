<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    protected $maps = [
        /**
         * 图片上传规则
         */
        'image'=>[
            'base_path'=>'/uploads/images/',
            'path'=>'Y/m/d',
            'validate'=>'required|file|image|max:2048'
        ],
        /**
         * pdf上传规则
         */
        'pdf'=>[
            'base_path'=>'/uploads/pdf/',
            'path'=>'Y/m/d',
            'validate'=>'required|file|mimetypes:application/pdf|mimes:pdf|max:20480'
        ],
        'video'=>[
            'base_path'=>'/uploads/videos/',
            'path'=>'Y/m/d',
            'validate'=>'required|file|max:20480'
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
        $map =  Arr::get($this->maps,$type);
        $path = $map['base_path'].date($map['path']);
        if($request->input('file_type')==1){
            $file_content = $request->get('file');
            $path_file = $path.md5($file_content).'.jpg';
            Storage::disk($disk)->put($path_file,base64_decode($file_content));
        }else{
            $file = $request->file('file');
            $path_file = Storage::disk($disk)->putFile($path,$file);
        }
        if(!$path_file){
            return Response::returns(['alert' => alert([
                'message' => trans('Upload failed!'),
                'success'=>0], 500)],500);
        };
        $url = Storage::disk($disk)->url($path_file);
        $transport = config('filesystems.disks.'.$disk.'.transport','');
        if($transport=='https'){
            $url = Str::replaceFirst('http://',$transport.'://',$url);
        }elseif($transport=='http'){
            $url = Str::replaceFirst('https://',$transport.'://',$url);
        }
        return Response::returns([
            'url'=>$url,
            'path'=>$path_file,
            'save_name'=>basename($path_file),
            'state'=>'SUCCESS',
            'success'=>1,
            'message'=>trans("Uploaded successfully!"),
            'disk'=>$disk
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
        $validate = [
            'file' => Arr::get($this->maps,$type.'.validate',''), //文件验证
            'type'=>'nullable|in:'.collect($this->maps)->keys()->implode(','), //上传类型
            'disk'=>'nullable|in:public' //上传磁盘
        ];
        if($request->input('file_type')==1){
            $validate['file'] = 'required';
        }
        return $validate;
    }



    public function alibabaCloudCreateUploadVideo(){
        $request = Request::instance();
        $validate = [
            'file_name' => 'required',//文件名信息
            'key'=>'required'
        ];
        $validator = Validator::make($request->all(), $validate);
        if ($validator->fails()) {
            return Response::returns([
                'errors' => $validator->errors()->toArray(),
                'message' => 'The given data was invalid.'
            ], 422);
        }
        $map =  Arr::get($this->maps,'video');
        $path = $map['base_path'].date($map['path']);
        $file_name = $request->input('file_name');
        \App\Facades\AlibabaCloud::regionId("cn-shanghai")
            ->asDefaultClient();
        $file_path = $path.'/'.$request->input('key');
        try {
            $response = \AlibabaCloud\Client\AlibabaCloud::vod()
                ->v20170321()
                ->createUploadVideo()
                ->withFileName($file_path)
                ->withTitle($file_name)
                ->request();
            $data = $response->toArray();
            $data['file_path'] = $file_path;
            return $data;
        }catch (\Exception $exception) {
            $message = $exception->getErrorMessage();
            return Response::returns(['alert' => alert([
                'title'=>'获取失败!',
                'message' => $message
            ], 500)],500);
        };
    }

    public function alibabaCloudRefreshUploadVideo(){
        $request = Request::instance();
        $validate = [
            'video_id' => 'required'//文件名信息
        ];
        $validator = Validator::make($request->all(), $validate);
        if ($validator->fails()) {
            return Response::returns([
                'errors' => $validator->errors()->toArray(),
                'message' => 'The given data was invalid.'
            ], 422);
        }
        \App\Facades\AlibabaCloud::regionId("cn-shanghai")
            ->asDefaultClient();
        try {
            $response = \AlibabaCloud\Client\AlibabaCloud::vod()
                ->v20170321()
                ->refreshUploadVideo()
                ->withVideoId($request->input('video_id'))
                ->request();
            return $response->toArray();
        }catch (\Exception $exception) {
            $message = $exception->getErrorMessage();
            return Response::returns(['alert' => alert([
                'title'=>'获取失败!',
                'message' => $message
            ], 500)],500);
        };
    }


}
