<?php

namespace App\Http\Controllers\Admin;


use App\Models\Admin;
use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class IndexController extends Controller
{

    /**
     * 后台首页数据
     * @return array
     */
    public function index(){
        $data = [];
        $data['count'] = [ //统计
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
        ];
        return $data;
    }

    /**
     * 错误日志下载
     * @return string|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downLog(){
        if($f = Request::input('f')){
            $file = str_replace('..','','firms/'.$f.'/log-'.date('Y-m-d').'.log');
        }else{
            $file = str_replace('..','',Request::input('file','laravel-'.date('Y-m-d').'.log'));
        }
        $file = storage_path('/logs/'.$file);
        if(!file_exists($file)){
            return trans('File does not exist!');
        }
        return response()->download($file);
    }



}
