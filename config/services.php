<?php
return (function(){
    $redirect = env('APP_URL').'/open/login?type=';
    return [
        /*
        |--------------------------------------------------------------------------
        | Third Party Services
        |--------------------------------------------------------------------------
        |
        | This file is for storing the credentials for third party services such
        | as Mailgun, Postmark, AWS and more. This file provides the de facto
        | location for this type of information, allowing packages to have
        | a conventional file to locate the various service credentials.
        |
        */

        'mailgun' => [
            'domain' => env('MAILGUN_DOMAIN'),
            'secret' => env('MAILGUN_SECRET'),
            'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        ],

        'postmark' => [
            'token' => env('POSTMARK_TOKEN'),
        ],

        'ses' => [
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
        ],

        'weibo' => [
            'client_id' => env('WEIBO_KEY'),
            'client_secret' => env('WEIBO_SECRET'),
            'redirect' => $redirect.'weibo',
        ],
        'qq' => [
            'client_id' => env('QQ_KEY'),
            'client_secret' => env('QQ_SECRET'),
            'redirect' => $redirect.'qq',
        ],
        'weixin' => [
            'client_id' => env('WEIXIN_KEY'),
            'client_secret' => env('WEIXIN_SECRET'),
            'redirect' => $redirect.'weixin',
        ],
        'weixinweb' => [
            'client_id' => env('WEIXINWEB_KEY'),
            'client_secret' => env('WEIXINWEB_SECRET'),
            'redirect' => $redirect.'weixinweb',
        ]

    ];
})();

