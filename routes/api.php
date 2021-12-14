<?php
use Illuminate\Http\Request;
use \App\Services\RouteService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

RouteService::routeRegisterApi();
//错误路由匹配
RouteService::any(false);
