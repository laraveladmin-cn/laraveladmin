<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Redis;
use Swoole\Runtime;
use Tests\TestCase;
use Swoole\Coroutine;
use Illuminate\Support\Facades\DB;

class SwooleDatabaseTest extends TestCase
{
    /**
     * 普通redis连接调用
     * @return void
     */
    public function testRedis()
    {
        $key = 'phpunit_test_redis';
        $redis = Redis::connection();
        $redis->command('SET',[$key,0]);
        $number1 = 10000;
        for ($n = $number1; $n--;) {
            $redis->command('INCR',[$key]);
        }
        $number = $redis->command('get',[$key]);
        $this->assertTrue($number==$number1);
    }

    /**
     * 协程并行调用
     * @return void
     * @throws \ErrorException
     */
    public function testCoroutineRedis(){
        $key = 'phpunit_test_redis';
        $redis = Redis::connection();
        $number1 = 10000;
        $number = 0;
        Coroutine\run(function ()use($redis,$key,&$number1,&$number) {
            $redis->command('SET',[$key,0]);
            $coroutine_number = 100;
            for ($n = $coroutine_number; $n--;) {
                Coroutine::create(function () use(&$redis,&$key,&$number1,$coroutine_number,&$number) {
                    for ($i = $number1/$coroutine_number; $i--;) {
                        $val = $redis->command('INCR',[$key]);
                        if($number<$val){
                            $number = $val;
                        }
                    }
                });
            }
        });
        $this->assertTrue($number==$number1);
    }

    /**
     * 普通常规查询修改数据表
     * @return void
     */
    public function testMysql()
    {
        $flog = true;
        for ($n = 100; $n--;) {
            $user = User::query()->find(1);
            if($user===false){
                $flog = false;
            }
            $res = DB::update('UPDATE `users` SET `updated_at` = "'.now()->toDateTimeString().'" WHERE `id` = 1');
            if($res===false){
                $flog = false;
            }
        }
        $this->assertTrue($flog);
    }


    /**
     * 协程数据库查询
     * @return void
     */
    public function testCoroutineMysql()
    {
        $flog = true;
        Coroutine\run(function ()use(&$flog) {
            for ($n = 10; $n--;) {
                Coroutine::create(function ()use(&$flog)   {
                    for ($n = 10; $n--;) {
                        $user = User::query()->find(1);
                        if($user===false){
                            $flog = false;
                        }
                        $res = DB::update('UPDATE `users` SET `updated_at` = "'.now()->toDateTimeString().'" WHERE `id` = 1');
                        if($res===false){
                            $flog = false;
                        }
                    }
                });
            }
        });
        $this->assertTrue($flog);
    }





}
