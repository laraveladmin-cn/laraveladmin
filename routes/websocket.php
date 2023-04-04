<?php


use Illuminate\Http\Request;
use SwooleTW\Http\Websocket\Facades\Websocket;

/*
|--------------------------------------------------------------------------
| Websocket Routes
|--------------------------------------------------------------------------
|
| Here is where you can register websocket events for your application.
|
*/
//连接成功消息回调
Websocket::on('connect', function ($websocket, Request $request) {
    // called while socket on connect
    $websocket->emit('message', 'welcome:'.collect($request->user())->toJson());
});
//断开连接消息回调
Websocket::on('disconnect', function ($websocket) {
    // called while socket on disconnect
});

Websocket::on('example', function ($websocket, $data) {
    $websocket->emit('message', $data);
});
