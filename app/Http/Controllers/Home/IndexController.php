<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class IndexController extends Controller
{
    public function index(){
        return Response::returns([
            'user'=>Auth::user()
        ]);
    }

}
