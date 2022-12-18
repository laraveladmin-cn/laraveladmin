<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Doc;
use Illuminate\Support\Facades\Response;

class IndexController extends Controller
{
    public function index(){
        $data = [];
        return Response::returns($data);
    }

    /**
     * 文档
     */
    public function getDocs($any=''){
        $path = $any;
        return Doc::where('name',$path)->value('description') ?: '没有更多内容了...';

    }

}
