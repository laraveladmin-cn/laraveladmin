<?php
return [
    'domain_auto'=>env('APP_DOMAIN_AUTO',false),
    'web_api_model'=>env('WEB_API_MODEL','api'), //页面请求模式:api或web
    'api_route_prefix'=>'api', //API路由前缀
    'web_route_prefix'=>'web-api', //web Api路由前缀
    'with_api'=>false, //web_api_model 为web模式设置
    'name_short' => env('APP_NAME_SHORT', 'Laravel'), //简称
    'logo' => env('APP_LOGO','/dist/img/logo.png'), //LOGO
    'icp'=>env('ICP',''), //备案号
    'communication_mode'=>[
        'forgot_password'=>[ //忘记密码通讯方式
            'email'=>'Email', //电子邮箱
            'mobile_phone'=>'Mobile Phone'//手机号
        ],
        'register'=>[ //注册用户通讯方式
            'email'=>'Email', //电子邮箱
            'mobile_phone'=>'Mobile Phone'//手机号
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
            'key'=>'other_login',
            'back_url'=>'other_login_back_url'
        ],

        'verify'=>[
            'login_num_key'=>'login_num'
        ]
    ],
    'client_id_key'=>'Client-Id', //接口请求认证的header键
    'no_remember_lifetime'=>120,//登录的不记住我过期时间(分钟) 设置值要小于session.lifetime的值
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
    'register_login'=>false, //注册成功后自动登录该用户
    'log_exclude_method'=>[ //操作日志记录排除的请求方式
        'get'
    ],
    'log_id_key'=>'_log_id', //登录次数缓存key
    'disabled_menus'=>env('DISABLED_MENUS', ''), //禁用菜单位(将禁用其所有子集)
    'locales'=>['zh-CN','zh-TW','en',
        'ja',   //日文
        'ko',  //韩文
        'fr',  //法语
        'ru',   //俄语
        'es',  //西班牙语
        'pt',  //葡萄牙语
        'fr',  //法语
        'de', //德语
        'it' //意大利语
    ], //支持语言
    'trans_prefix'=>'_trans_', //翻译语言前缀
    'tinymce_key'=>env('TINYMCE_KEY',''), //tinymce编辑器key
    'sso'=>env('SINGLE_SIGN_ON',false), //是否单点登录
    'amap'=>[
        'js_api'=>[
            'key'=>env('AMAP_JS_API_KEY',''),
            'secret'=>env('AMAP_JS_API_SECRET','')
        ],
        'web_api'=>[
            'key'=>env('AMAP_WEB_API_KEY',''),
        ]
    ],
    'google'=>[
        'js_api'=>[
            'key'=>env('GOOGLE_JS_API_KEY',''),
        ],
        'web_api'=>[
            'key'=>env('GOOGLE_WEB_API_KEY',''),
        ]
    ]

];
