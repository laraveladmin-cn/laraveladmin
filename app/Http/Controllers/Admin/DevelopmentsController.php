<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use KubAT\PhpSimple\HtmlDomParser;

class DevelopmentsController extends Controller
{

    /**
     * 后台首页数据
     * @return array
     */
    public function index(){
        $data = [];
        return $data;
    }

    /**
     * 保存拖拽后的布局
     */
    public function postLayout(\Illuminate\Http\Request $request){
        $this->validate($request,[
            'path'=>'required|string',
            'items'=>'required|array'
        ]);//验证数据
        $data = Request::all();
        $errors = [];
        $path = resource_path('/js/'.$data['path']);
        if(str_contains($data['path'],'..')){
            $errors[] = '路径中不能包含".."';
        }elseif(!file_exists($path)){
            $errors[] = '代码文件不存在!';
        }
        if($errors){
            return Response::returns([
                'message' => '参数错误',
                'errors' => [
                    'path' => $errors
                ]
            ], 422);
        }
        $content = file_get_contents($path);
        $dom = HtmlDomParser::str_get_html( $content);
        $all_items = collect($data['items'])->collapse()->toArray();
        //代码中所有可拖动节点
        $items = collect($dom->find('edit-item,.move-item'))->map(function ($item)use ($all_items){
            $key = Arr::get($item->attr,'key-name','');
            $data = [
                'key'=>Arr::get($item->attr,'key-name',''),
                'dom'=>$item->outertext
            ];
            //清理代码中可拖拽节点
            if($key && in_array($key,$all_items)){
                $item->outertext = '';
            }
            return $data;
        })->groupBy('key')
            ->map(function ($items){
            return $items->pluck('dom')->implode("\r\n");
        });
        //代码中所有节点容器
        collect($dom->find('.move-items'))->map(function ($group,$index)use($data,$items){
            $order = Arr::get($data['items'],$index,[]);
            $group->innertext = collect($order)->map(function ($value)use($items){
                return $items[$value];
            })->implode("\r\n").$group->innertext;
        });
        $res = file_put_contents(resource_path('/js/'.$data['path']), $dom->outertext );
        if($res===false){
            return Response::returns(['alert' => alert(['message' => '代码写入文件失败!'])],500);
        }
        return Response::returns(['alert' => alert(['message' => '代码已更新成功!'])],200);
    }





}
