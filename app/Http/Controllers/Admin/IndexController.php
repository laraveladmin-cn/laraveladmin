<?php

namespace App\Http\Controllers\Admin;


use App\Models\Admin;
use App\Models\Log;
use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class IndexController extends Controller
{

    /**
     * 后台首页数据
     * @return array
     */
    public function index(){
        $data = [];
        $data['count'] = collect([ //统计
            [
                'name'=>'Total number of back-end administrators',
                'value'=>Admin::count(),
                'class'=>'bg-aqua',
                'icon'=>'fa-hand-pointer-o',
                'url'=>'/admin/admins'
            ],
            [
                'name'=>'Total number of roles',
                'value'=>Role::count(),
                'class'=>'bg-green',
                'icon'=>'fa-cubes',
                'url'=>'/admin/roles'
            ],
            [
                'name'=>'Total number of users',
                'value'=>User::query()->whereDoesntHave('admin')->count(),
                'class'=>'bg-yellow',
                'icon'=>'fa-users',
                'url'=>'/admin/users'
            ],
            [
                'name'=>'Total number of menus',
                'value'=>Menu::count(),
                'class'=>'bg-red',
                'icon'=>'fa-sitemap',
                'url'=>'/admin/menus'
            ],
        ])->map(function ($item){
            $item[config('laravel_admin.trans_prefix').'name'] = trans_path($item['name'],'_shared.pages.admin');
            return $item;
        })->toArray();
        $data['access'] = Log::where('menu_id',Menu::where('url','/open/login')
            ->where('method','&',2)
            ->value('id'))
            ->where('user_id','<>',0)
            ->where('created_at','>=',Carbon::now()->subMonth()->toDateString())
            ->selectRaw(DB::raw('LEFT(created_at,10) as date,COUNT(*) as value,COUNT(DISTINCT `ip`) as distinct_value'))
            ->groupBy(DB::raw('LEFT(created_at,10)'))
            ->get();//访问统计数据
        return $data;
    }

    /**
     * 错误日志下载
     * @return string|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downLog(){
        $request = app('request');
        $this->validate($request,['file'=>'required']);
        $file = str_replace('..','',Request::input('file','laravel-'.date('Y-m-d').'.log'));
        $file = storage_path('/logs/'.$file);
        if(!file_exists($file)){
            return trans('File does not exist!');
        }
        return response()->download($file);
    }



}
