<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use \SocialiteProviders\Manager\SocialiteWasCalled;
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SocialiteWasCalled::class => [
            'SocialiteProviders\Weibo\WeiboExtendSocialite@handle',
            'SocialiteProviders\QQ\QqExtendSocialite@handle',
            'SocialiteProviders\WeixinWeb\WeixinWebExtendSocialite@handle',
            'SocialiteProviders\WeixinWeb\TelegramExtendSocialite@handle',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
