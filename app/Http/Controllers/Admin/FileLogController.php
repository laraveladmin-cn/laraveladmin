<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileLogController extends Controller
{

    /**
     * 后台首页数据
     * @return array
     */
    public function index(){
        $app_url = config('app.url');
        $where_file = Request::input('where.file','');
        $order = Request::input('order',['updated_at'=>'desc']);
        $files = collect(Storage::disk('logs')->allFiles())
            ->filter(function ($path)use($where_file){
                $res = !Str::startsWith($path,'.');
                if($where_file!=='' && $res){
                    $res = str_contains($path,$where_file);
                }
                return $res;
            })
            ->values()
            ->map(function ($path,$key)use($app_url){
                $size = Storage::disk('logs')->size($path);
            return [
                'id'=>$key+1,
                'url'=>$app_url.getRoutePrefix('web').'/admin/down-log?file='.$path,
                'file'=>$path,
                'size'=>$size,
                'size_format'=>$this->getFilesize($size),
                'updated_at'=>date('Y-m-d H:i:s',Storage::disk('logs')->lastModified($path))
            ];
        });
        if($order){
            $key = collect($order)->keys()->first();
            collect($order)->only($key)->map(function ($value,$key)use(&$files){
                if($value=='asc'){
                    $files = $files->sortBy($key)->values();
                }else{
                    $files = $files->sortByDesc($key)->values();
                }
            });
        }
        $downloadUrl = '/admin/down-log';
        $data = [
            'list'=>['data'=>$files],
            'options'=>[
                'where'=>Request::input('where',[
                    'file'=>''
                ]),
                'order'=>$order
            ],
            'configUrl'=>[
                'indexUrl'=>'/admin/file-log/index',
                'downloadUrl'=>Menu::hasPermission($downloadUrl,'get') ? $downloadUrl : ''
            ]
        ];
        return $data;
    }

    /**
     * 格式化文件大小
     * @param $num
     * @return string
     */
    protected function getFilesize($num){
        $units = [
            'B',
            'KB',
            'MB',
            'GB',
            'TB'
        ];
        $decimals = [
            0,
            0,
            2,
            3,
            3
        ];
        $p = 0;
        $format = $units[0];
        collect($units)->each(function ($unit,$key)use(&$p,$num,&$format){
            if ($num >= pow(1024, $key) && $num < pow(1024, $key+1)) {
                $p = $key>3?3:$key;
                $format = $unit;
                return false;
            }
        });
        if(!$p){
            return $num . ' ' . $format;
        }
        $num /= pow(1024, $p);
        $decimal = Arr::get($decimals,$p,0);
        return number_format($num, $decimal) . ' ' . $format;
    }



}
