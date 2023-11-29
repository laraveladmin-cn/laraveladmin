<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use \App\Services\RouteService;
if(in_array(config('app.env'),['local','testing'])){
    Route::get('/api-doc-debug', \App\Http\Controllers\Open\IndexController::class.'@apiDoc');
}
//页面路由
RouteService::routeRegisterWeb();
//错误路由匹配
RouteService::any();
