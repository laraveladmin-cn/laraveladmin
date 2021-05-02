<?php
return [
    'web_api_model'=>env('WEB_API_MODEL','api'), //页面请求模式:api或web
    'api_route_prefix'=>'api', //API路由前缀
    'web_route_prefix'=>'web-api', //web Api路由前缀
    'with_api'=>false, //web_api_model 为web模式设置
    'name_short' => env('APP_NAME_SHORT', 'Laravel'), //简称
    'logo' => env('APP_LOGO','/dist/img/logo.png'), //LOGO
    'icp'=>env('ICP',''), //备案号
    'communication_mode'=>[
        'forgot_password'=>[ //忘记密码通讯方式
            'email'=>'电子邮箱',
            'mobile_phone'=>'手机号'
        ],
        'register'=>[ //注册用户通讯方式
            'email'=>'电子邮箱',
            'mobile_phone'=>'手机号'
        ]
    ],
    'verify'=>[
        'type'=>env('APP_VERIFY_TYPE','geetest'), //登录注册验证类型
        'login_pass_num'=>env('APP_VERIFY_LOGIN_PASS_NUM','1')//登录验证允许次数
    ],
    'admin_user_name'=>env('ADMIN_USER_NAME', 'admin'), //系统账号用户名
    'admin_password'=>env('ADMIN_PASSWORD', '123456'), //系统账号密码
    'store_keys'=>[
        //短信验证码
        'sms'=>[
            'code_key'=>'sms_codes', //注册用户验证码存放键
            'forgot_password_key'=>'forgot_password_code', //忘记密码验证码存放键
            'forbidden'=>60, //禁止发送时长
            'refuse_num'=>5, //发送多少次短信后拒绝发送
            'refuse_time'=>1800, //拒绝发送失效时间
            'verify_num'=>3 //验证码最多验证次数后需要验证验证码,防止暴力验证
        ],


        /**
         * 三方登录数据存放
         * 用于绑定登录用户,及绑定注册用户
         */
        'other_login'=>[
            'key'=>'other_login'
        ],

        'verify'=>[
            'login_num_key'=>'login_num'
        ]
    ],
    'client_id_key'=>'Client-Id',
    //登录的记住我过期时间(天)
    'remember_lifetime'=>7,
    'ali_dayu' => [
        'app_key' => env('ALIYUN_SMS_AK',''), //APP KEY
        'app_secret' => env('ALIYUN_SMS_AS',''), //APP SECRET
        'signature'=>menv('ALI_DAYU_SIGNATURE',''), //短信签名:可以使用网站名称
        'template_codes'=>[ //模板代码
            'register'=>env('ALI_DAYU_CODE_REGISTER',''), //用户注册短信模板
            'login'=>env('ALI_DAYU_CODE_LOGIN',''), //用户注册短信模板
            'forgot'=>env('ALI_DAYU_CODE_FORGOT',''), //用户注册短信模板
        ]
    ],
    'register_login'=>false,
    'log_exclude_method'=>[
        'get'
    ],
    'log_id_key'=>'_log_id',
    'disabled_menus'=>env('DISABLED_MENUS', ''),
    'locales'=>['zh_CN','zh_TW','en'], //支持语言
    'trans_prefix'=>'_trans_' //翻译语言前缀

];
