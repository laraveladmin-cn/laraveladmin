<?php
/**
 * phpswoole清理数据
 */
namespace App\Services;

use EasyWeChat\MiniProgram\Application as MiniProgram;
use EasyWeChat\OfficialAccount\Application as OfficialAccount;
use EasyWeChat\OpenPlatform\Application as OpenPlatform;
use EasyWeChat\Payment\Application as Payment;
use EasyWeChat\Work\Application as Work;
use Illuminate\Contracts\Container\Container;
use SwooleTW\Http\Server\Resetters\ResetterContract;
use SwooleTW\Http\Server\Sandbox;

class ResetProviders implements ResetterContract
{
    /**
     * "handle" function for resetting app.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     * @param \SwooleTW\Http\Server\Sandbox $sandbox
     *
     * @return \Illuminate\Contracts\Container\Container
     */
    public function handle(Container $app, Sandbox $sandbox)
    {
        //清理微信相关对象
        $apps = [
            'official_account' => OfficialAccount::class,
            'work' => Work::class,
            'mini_program' => MiniProgram::class,
            'payment' => Payment::class,
            'open_platform' => OpenPlatform::class,
        ];
        foreach ($apps as $name => $class) {
            if (empty(config('wechat.'.$name))) {
                continue;
            }
            if (!empty(config('wechat.'.$name.'.app_id')) || !empty(config('wechat.'.$name.'.corp_id'))) {
                $accounts = [
                    'default' => config('wechat.'.$name),
                ];
                config(['wechat.'.$name.'.default' => $accounts['default']]);
            } else {
                $accounts = config('wechat.'.$name);
            }
            foreach ($accounts as $account => $config) {
                $app->forgetInstance("wechat.{$name}.{$account}");
            }
        }

        return $app;
    }
}
