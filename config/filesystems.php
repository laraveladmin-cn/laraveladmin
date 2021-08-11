<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [
        'root' => [
            'driver' => 'local',
            'root' => base_path(),
        ],
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],
        'migrations' => [
            'driver' => 'local',
            'root' => database_path('migrations'),
        ],
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],
        'qiniu_public' => [
            'driver' => 'qiniu',
            'domains' => [
                'default' => env('QINIU_DOMAIN_PUBLIC'),//你的七牛域名
                'https' => '',         //你的HTTPS域名
                'custom' => env('QINIU_DOMAIN_PUBLIC'),                //Useless 没啥用，请直接使用上面的 default 项
            ],
            'access_key' => env('QINIU_ACCESS_KEY'),//AccessKey
            'secret_key' => env('QINIU_SECRET_KEY'),//SecretKey
            'bucket' => env('QINIU_BUCKET_PUBLIC', 'upload'),//Bucket名字(空间名称)
            'transport' => env('QINIU_TRANSPORT', 'http'),//如果支持https，请填写https，如果不支持请填写http
            'visibility' => 'public',
            'access' => 'public',  //空间访问控制 public 或 private
            'notify_url' => '',  //持久化处理回调地址
            'hotlink_prevention_key' => null, // CDN 时间戳防盗链的 key。 设置为 null 则不启用本功能。
        ],
        'logs'=>[
            'driver' => 'local',
            'root' => storage_path('logs'),
        ]

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
