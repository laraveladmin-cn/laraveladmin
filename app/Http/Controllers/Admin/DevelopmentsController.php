<?php

namespace App\Http\Controllers\Admin;

use App\Facades\LifeData;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Table;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use KubAT\PhpSimple\HtmlDomParser;

class DevelopmentsController extends Controller
{
    protected $commands = [];

    public function __construct()
    {
        //读取命令列表
        $file = storage_path('developments/commands.json');
        if(file_exists($file)){
            $this->commands = json_decode(file_get_contents($file),true);
        }
    }

    /**
     * 后台首页数据
     * @return array
     */
    public function index(){
        $submit = '/admin/developments/command';
        $commands = collect($this->commands)->map(function ($command,$index){
            $command['_id'] = $index+1;
            $command['parameters'] = collect(Arr::get($command,'parameters',[]))->map(function ($parameter){
                $parameter['_value'] = $parameter['value'];
                return $parameter;
            });
            $command['_exec'] = '';
            return $command;
        })->toArray();
        $index = 1;
        $data = [
            'row'=>$commands[$index-1],
            'commands'=>$commands,
            'configUrl'=>[
                'createUrl'=>Menu::hasPermission($submit,'post') ? $submit : ''
            ],
            'maps'=>[
                //可选数据库
                'database'=>collect(config('database.connections'))
                    ->filter(function ($item,$key){
                        return $item['driver']=='mysql' && $key!='schema';
                    })
                    ->map(function ($item,$key){
                    return $key;
                })->toArray()
            ],
            'index'=>$index,
            'history'=>[],
        ];
        return $data;
    }

    /**
     * 菜单路由页面
     */
    public function menus(){

    }

    /**
     * 调用命令
     */
    public function postCommand(\Illuminate\Http\Request $request){
        $this->validate($request,[
            '_exec'=>'required|string'
        ]);
        $exitCode = Artisan::call($request->input('_exec'));
        if($exitCode){
            return Response::returns([
                'alert' => alert(['message' => '执行失败!'],500),
                'output'=>Artisan::output()
            ],500);
        }
        return Response::returns([
            'alert' => alert(['message' => '执行成功!']),
            'output'=>Artisan::output()
        ]);
    }

    /**
     * 查询数据表
     */
    public function tables(\Illuminate\Http\Request $request){
        $validator = Validator::make($request->all(),[
            'where.TABLE_NAME'=>'nullable|string',
            'connection'=>'nullable|string',
        ]);
        if ($validator->fails()) {
            return Response::returns([
                'errors' => $validator->errors()->toArray(),
                'message' => 'The given data was invalid.'
            ], 422);
        }
        $connection = $request->input('connection')?:config('database.default');
        $tname = $request->input('where.TABLE_NAME');
        $tableModel = new Table();
        $tableModel = $tableModel->setConnection($connection)
            ->setTable(DB::raw('information_schema.`TABLES`'))
            ->where('TABLE_SCHEMA',config('database.connections.'.$connection.'.database'))
            ->where('TABLE_NAME','like','%'.$tname.'%');
               //获取分页数据
        if (!Request::input('page') || Request::input('get_count')) {
            $data = $tableModel->paginate();
        } else { //不统计条数
            $data = $tableModel->simplePaginate();
        }
        //返回响应数据存放,方便操作日志记录
        LifeData::set('list', $data);
        return $data;
    }

    /**
     * 保存拖拽后的布局
     */
    public function postLayout(\Illuminate\Http\Request $request){
        $validator = Validator::make($request->all(),[
            'path'=>'required|string',
            'items'=>'required|array'
        ]);
        if ($validator->fails()) {
            return Response::returns([
                'errors' => $validator->errors()->toArray(),
                'message' => 'The given data was invalid.'
            ], 422);
        }
        $data = Request::all();
        $errors = [];
        $path = resource_path('js'.$data['path']);
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
        $dom = HtmlDomParser::str_get_html( file_get_contents($path));
        $template = $dom->find('template')[0]; //dom节点
        $template->outertext = preg_replace('/\s+</', '<', $template->outertext);
        $dom = HtmlDomParser::str_get_html($dom->outertext);
        $all_items = collect($data['items'])->collapse()->toArray();
        //代码中所有可拖动节点
        $items = collect($dom->find('edit-item,.move-item'))->map(function (&$item)use ($all_items){
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
            return $items->pluck('dom')->implode('');
        });
        //代码中所有节点容器
        collect($dom->find('.move-items'))->map(function ($group,$index)use($data,$items){
            $order = Arr::get($data['items'],$index,[]);
            $group->innertext = collect($order)->map(function ($value)use($items){
                return $items[$value];
            })->implode('').$group->innertext;
        });
        $template = $dom->find('template')[0]; //dom节点
        $template->outertext = preg_replace('/\s+</', '<', $template->outertext);
        $dom = HtmlDomParser::str_get_html($dom->outertext);
        $template = $dom->find('template')[0]; //dom节点
        $this->format($template);
        $content = preg_replace('/\s+<script>/', "\n<script>",trim($dom->outertext));
        $res = file_put_contents($path, $content );
        if($res===false){
            return Response::returns(['alert' => alert(['message' => '代码写入文件失败!'])],500);
        }
        return Response::returns(['alert' => alert(['message' => '代码已更新成功!'])],200);
    }

    /**
     * HTML代码格式化
     */
    protected function format($el,$level=0,$is_last=true){
        $children = $el->children();
        if(!$children){
            $outertext = preg_replace('/\s{2,}/', "\n",preg_replace('/<\//', "\n</",$el->outertext));
            $arr = explode("\n",$outertext);
            $last = count($arr)-1;
            $outertext = collect($arr)->map(function ($row,$i)use($last,$level){
                if($i==0 || $i==$last){
                    $row = $this->pixSpace($level).trim($row);
                }else{
                    $row = $this->pixSpace($level+1).trim($row);
                }
                return $row;
            })->implode("\n");
            if($is_last){
                $el->outertext = "\n".$outertext."\n".$this->pixSpace($level-1);
            }else{
                $el->outertext = "\n".$outertext;
            }
            return $el->outertext;
        }else{
            $count = count($children)-1;
            foreach ($children as $index=>$child){
                $child->innertext = $this->format($child,$level+1,$count==$index);
            }
            if($is_last){
                $el->outertext = "\n".$this->pixSpace($level).trim($el->outertext)."\n".$this->pixSpace($level-1);
            }else{
                $el->outertext = "\n".$this->pixSpace($level).trim($el->outertext);
            }
            return $el->outertext;
        }
    }

    /**
     * 空格前缀
     */
    protected function pixSpace($num){
        $str = '';
        for($i=0;$i<$num;$i++){
            $str .='    ';
        }
        return $str;
    }







}
