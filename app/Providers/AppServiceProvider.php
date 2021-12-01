<?php

namespace App\Providers;

use App\Console\DevelopCommands\BuildApiDoc;
use App\Console\DevelopCommands\CreateAll;
use App\Console\DevelopCommands\CreateController;
use App\Console\DevelopCommands\CreateModel;
use App\Console\DevelopCommands\CreateSeed;
use App\Console\DevelopCommands\CreateView;
use App\Facades\LifeData;
use App\Models\Traits\DbMysqlImplModel;
use App\Models\Traits\NestedSetsService;
use App\Services\ClientAuth;
use App\Services\FormatterService;
use App\Services\LifeDataRepository;
use App\Services\OptionRepository;
use App\Services\SMSNewService;
use App\Validators\CustomValidator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //移动端唯一标识生成
        $this->app->singleton('app_client', ClientAuth::class);
        //返回数据存放
        $this->app->singleton('life_data', LifeDataRepository::class);
        //系统配置
        $this->app->singleton('option', OptionRepository::class);
        //数据结构格式化
        $this->app->singleton('formatter', FormatterService::class);
        //极验验证码
        $this->app->singleton('geetest', function () {
            return $this->app->make('ZBrettonYe\Geetest\GeetestLib');
        });

        //短信发送
        $this->app->singleton('sms' , function($app){
            return new SMSNewService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(ResponseFactory $factory)
    {
        Schema::defaultStringLength(191);
        //响应返回
        $factory->macro('returns', function ($value=[],$status=200,array $headers = []) use ($factory) {
            $value = collect(LifeData::all())->only(['options','list'])->merge($value)->toArray();
            collect($value)->each(function ($value,$key){
                LifeData::set($key,$value);
            });
            if(Request::input('callback')){ //jsonp
                return $factory->jsonp(Request::input('callback'),$value,$status);
                $headers['Content-Type'] = 'application/javascript';
            }elseif(Request::input('define')=='AMD'){ //AMD
                $value = 'define([],function(){ return '.collect($value)->toJson().';});';
                $headers['Content-Type'] = 'application/javascript';
            }elseif(Request::input('define')=='CMD'){ //CMD
                $value = 'define([],function(){ return '.collect($value)->toJson().';});';
                $headers['Content-Type'] = 'application/javascript';
            }elseif(Request::has('dd')){ //数据打印页面
                dd($value->toArray());
            }elseif(Request::has('script')){ //页面
                $value = 'var '.Request::input('script').' = '.collect($value)->toJson().';';
                $headers['Content-Type'] = 'application/javascript';
            }else{
                return $factory->json($value,$status,$headers);
            }
            return $factory->make($value,$status,$headers);
        });

        //注册自定义验证
        $this->app['validator']->resolver(function($translator, $data, $rules, $messages=[],$customAttributes=[])
        {
            return new CustomValidator($translator, $data, $rules, $messages,$customAttributes);
        });
        $this->app->singleton('DbMysqlModel', function($app)
        {
            return new DbMysqlImplModel();
        });
        $this->app->singleton('NestedSetsService', function($app)
        {
            return new NestedSetsService($app['DbMysqlModel']);
        });
    }
}
