<?php

return [
    'default' => env('ALIBABACLOUD_DEFAULT_APP', 'default'),
    'apps' => [
        'default' => [
            'AccessKeyID' => env('ALIBABACLOUD_ACCESSKEY_ID',''),
            'AccessKeySecret'=>env('ALIBABACLOUD_ACCESSKEY_SECRET','')
        ],
    ],


];
